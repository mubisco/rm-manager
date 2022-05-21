<?php

namespace App\User\Infrastructure\Persistence\InMemory;

use App\User\Domain\User;
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
}
