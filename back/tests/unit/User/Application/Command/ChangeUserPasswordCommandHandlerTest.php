<?php

namespace App\Tests\unit\User\Application\Command;

use App\User\Application\Command\ChangeUserPasswordCommand;
use App\User\Application\Command\ChangeUserPasswordCommandHandler;
use App\User\Domain\PasswordChangeException;
use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordEncryptorException;
use App\User\Domain\User;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangeUserPasswordCommandHandlerTest extends TestCase
{
    private ChangeUserPasswordCommandHandler $sut;
    private UserRepository|MockObject $repository;
    private PasswordEncryptor $encryptor;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->encryptor = $this->createMock(PasswordEncryptor::class);
        $this->sut = new ChangeUserPasswordCommandHandler(
            $this->repository,
            $this->encryptor
        );
    }
    /** @test */
    public function itShouldThrowExceptionIfUsernameNotValid(): void
    {
        $this->expectException(PasswordChangeException::class);
        ($this->sut)(new ChangeUserPasswordCommand('us', 'pass'));
    }

    /** @test */
    public function itShouldThrowExceptionIfPasswordWrong(): void
    {
        $this->expectException(PasswordChangeException::class);
        ($this->sut)(new ChangeUserPasswordCommand('Agapit0', 'pass'));
    }
    /** @test */
    public function itShouldThrowExceptionWhenUserDoesNotExists(): void
    {
        $this->expectException(PasswordChangeException::class);
        $this->repository->method('byUsername')->willThrowException(new UserNotFoundException());
        ($this->sut)(new ChangeUserPasswordCommand('Agapit0', 'APassw0rd'));
    }

    /** @test */
    public function itShouldThrowExceptionIfEncryptionFails(): void
    {
        $this->expectException(PasswordChangeException::class);
        /** @var User|MockObject */
        $mockedUser = $this->createMock(User::class);
        $mockedUser->method('updatePassword')->willThrowException(new PasswordEncryptorException());
        $this->repository->method('byUsername')->willReturn($mockedUser);
        ($this->sut)(new ChangeUserPasswordCommand('Agapit0', 'APassw0rd'));
    }

    /** @test */
    public function itShouldThrowExceptionIfUserUpdateFails(): void
    {
        $this->expectException(PasswordChangeException::class);
        $this->repository->method('update')->willThrowException(new UserRepositoryException());
        ($this->sut)(new ChangeUserPasswordCommand('Agapit0', 'APassw0rd'));
    }

    /** @test */
    public function itShouldThrowNoExceptionsIfEverithingFine(): void
    {
        ($this->sut)(new ChangeUserPasswordCommand('Agapit0', 'APassw0rd'));
        $this->assertTrue(true);
    }
}
