<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\UnauthorizedUserException;
use App\User\Domain\User;
use App\User\Domain\UserEmail;
use App\User\Domain\UserPassword;
use App\User\Domain\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class DoctrineUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DoctrineUser $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(DoctrineUser $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof DoctrineUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function login(UserEmail $userEmail, UserPassword $userPassword): User
    {
        /** @var DoctrineUser|null */
        $user = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $userEmail->value())
            ->andWhere('u.password = :password')
            ->setParameter('password', $userPassword->value())
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if ($user === null) {
            throw new UnauthorizedUserException('Not authorized!!!');
        }
        return $user;
    }
}
