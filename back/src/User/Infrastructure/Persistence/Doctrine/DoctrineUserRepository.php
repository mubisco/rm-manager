<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\User;
use App\User\Domain\UserId;
use App\User\Domain\UserRepository;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class DoctrineUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepository
{
    public function __construct(
        private ManagerRegistry $registry,
    ) {
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

    public function update(User $user): User
    {
        $this->_em->flush();
        return $user;
    }

    public function store(User $user): User
    {
        $this->_em->persist($user);
        return $user;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof DoctrineUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', \get_class($user))
            );
        }
        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function byUsername(Username $username): User
    {
        return $this->simpleSearch('username', $username->value());
    }

    public function ofId(UserId $userId): User
    {
        return $this->simpleSearch('userId', $userId->value());
    }

    private function simpleSearch(string $key, string $value): User
    {
        /** @var User[] */
        $results = $this->findBy([$key => $value]);
        if (empty($results)) {
            throw new UserNotFoundException("User with {$key} {$value} not found!!");
        }
        return $results[0];
    }

    public function ofValidPasswordToken(PasswordToken $token): User
    {
        try {
            $userWithToken = $this->simpleSearch('resetPasswordToken', $token->value());
            if ($userWithToken->isTokenExpired()) {
                throw new PasswordTokenExpiredException("Token {$token->value()} expired!!!");
            }
            return $userWithToken;
        } catch (UserNotFoundException) {
            throw new PasswordTokenNotFoundException("Token {$token->value()} not found!!!");
        }
    }
}
