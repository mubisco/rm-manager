<?php

namespace App\Tests\integration\User\Infrastructure\Persistence\Doctrine;

use App\Tests\unit\User\Infrastructure\Persistence\Doctrine\DoctrineUserOM;
use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\UserId;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class DoctrineUserRepositoryIntegrationTest extends KernelTestCase
{
    private ?ManagerRegistry $managerRegistry;
    private DoctrineUserRepository $sut;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->sut = new DoctrineUserRepository($this->managerRegistry);
    }

    /** @test */
    public function itShouldAddUserProperly(): void
    {
        $user = DoctrineUserOM::aUser()->build();
        $this->sut->add($user, true);
        $userId = $user->userId();
        $foundUser = $this->sut->ofId($userId);
        $this->assertTrue($user->userId()->equalsTo($foundUser->userId()));
    }

    /** @test */
    public function itShouldThrowExceptionWhenUserNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $userId = UserId::fromEmpty();
        $this->sut->ofId($userId);
    }

    /** @test */
    public function itShouldThrowExceptionWhenUserNotFoundByUsername(): void
    {
        $this->expectException(UserNotFoundException::class);
        $username = new Username('segismundo');
        $this->sut->byUsername($username);
    }

    /** @test */
    public function itShouldThrowExceptionWhenNoUserFoundByToken(): void
    {
        $this->expectException(PasswordTokenNotFoundException::class);
        $passwordToken = PasswordToken::fromEmpty();
        $this->sut->ofValidPasswordToken($passwordToken);
    }

    /** @test */
    public function itShouldDeleteUserProperly(): void
    {
        $this->expectException(UserNotFoundException::class);
        $user = DoctrineUserOM::aUser()->build();
        $this->sut->store($user);
        $this->sut->remove($user, true);
        $this->sut->ofId($user->userId());
    }

    /** @test */
    public function itShoulUpdateUserProperly(): void
    {
        $user = DoctrineUserOM::aUser()->build();
        $this->sut->add($user, true);
        $userId = $user->userId();
        $foundUser = $this->sut->ofId($userId);
        $token = $foundUser->generateResetPasswordToken();
        $this->sut->update($foundUser);
        $passwordToken = PasswordToken::fromString($token);
        $reloadedUser = $this->sut->ofValidPasswordToken($passwordToken);
        $this->assertEquals($foundUser->passwordResetToken(), $reloadedUser->passwordResetToken());
    }

    /** @test */
    public function itShouldUpdatePasswordProperly(): void
    {
        $user = DoctrineUserOM::aUser()->build();
        $this->sut->add($user, true);
        $this->sut->upgradePassword($user, 'asdasdasd');
        /** @var DoctrineUser */
        $foundUser = $this->sut->ofId($user->userId());
        $this->assertEquals('asdasdasd', $foundUser->getPassword());
    }

    /** @test */
    public function itShouldThrowExceptionIfUpdatingaNonDoctrineUser(): void
    {
        $this->expectException(UnsupportedUserException::class);
        $mockedUser = $this->createMock(PasswordAuthenticatedUserInterface::class);
        $this->sut->upgradePassword($mockedUser, 'asdasdasd');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if ($this->managerRegistry) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->clear();
        }
        $this->managerRegistry = null;
    }
}
