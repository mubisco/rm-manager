<?php

namespace App\User\Infrastructure\Persistence\InMemory;

use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\User;
use App\User\Domain\UserId;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use PHPUnit\Framework\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testShouldBeOfProperClass(): void
    {
        $sut = new InMemoryUserRepository();
        $this->assertInstanceOf(InMemoryUserRepository::class, $sut);
        $this->assertInstanceOf(UserRepository::class, $sut);
    }

    public function testShouldThrowExceptionIfUserNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $sut = new InMemoryUserRepository();
        $sut->byUsername(new Username('nonexistantuser'));
    }

    public function testShouldReturnProperUser(): void
    {
        $sut = new InMemoryUserRepository();
        $result = $sut->byUsername(new Username('existinguser'));
        $this->assertEquals('existinguser', $result->user());
    }

    public function testShouldUpdateUser(): void
    {
        $sut = new InMemoryUserRepository();
        $result = $sut->byUsername(new Username('existinguser'));
        $token = $result->generateResetPasswordToken();
        $updatedUser = $sut->update($result);
        $this->assertInstanceOf(User::class, $updatedUser);
        /** @var DoctrineUser */
        $refreshedUser = $sut->byUsername(new Username('existinguser'));
        $this->assertEquals($token, $refreshedUser->passwordResetToken());
    }

    public function testShouldThrowExceptionIfUserWithIdNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $sut = new InMemoryUserRepository();
        $sut->ofId(UserId::fromEmpty());
    }

    public function testShouldReturnProperUserOfId(): void
    {
        $sut = new InMemoryUserRepository();
        $existingUser = $sut->byUsername(new Username('existinguser'));
        $result = $sut->ofId($existingUser->userId());
        $this->assertSame($existingUser, $result);
    }

    public function testShouldStoreProperUser(): void
    {
        $user = new DoctrineUser('test@test.com', 'username', 'password', ['ROLE_USER'], null, null);
        $sut = new InMemoryUserRepository();
        $result = $sut->store($user);
        $this->assertSame($user, $result);
        $storedUser = $sut->ofId($user->userId());
        $this->assertSame($user, $storedUser);
    }
    /**
     * @test
     */
    public function itShouldThrowNotFoundExceptionIfTokenDoesNotExists(): void
    {
        $this->expectException(PasswordTokenNotFoundException::class);
        $sut = new InMemoryUserRepository();
        $token = PasswordToken::fromEmpty();
        $sut->ofValidPasswordToken($token);
    }

    /**
     * @test
     */
    public function itShouldThrowExpiredExceptionIfTokenExpired(): void
    {
        $this->expectException(PasswordTokenExpiredException::class);
        $sut = new InMemoryUserRepository();
        $token = PasswordToken::fromString('99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507');
        $sut->ofValidPasswordToken($token);
    }

    /**
     * @test
     */
    public function itShouldReturnProperUserWhenTokenExistsAndNotExpired(): void
    {
        $sut = new InMemoryUserRepository();
        $token = PasswordToken::fromString('10c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507');
        $result = $sut->ofValidPasswordToken($token);
        $this->assertEquals('validTokenUser', $result->user());
    }
}
