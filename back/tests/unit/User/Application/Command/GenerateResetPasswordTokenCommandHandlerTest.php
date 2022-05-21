<?php

namespace App\User\Application\Command;

use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\User;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use App\User\Domain\WrongUsernameException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GenerateResetPasswordTokenCommandHandlerTest extends TestCase
{
    private GenerateResetPasswordTokenCommandHandler $sut;
    private GenerateResetPasswordTokenCommand $command;
    private MockObject|UserRepository $mockedRepository;

    protected function setUp(): void
    {
        $this->mockedRepository = $this->createMock(UserRepository::class);
        $this->command = new GenerateResetPasswordTokenCommand('username');
        $this->sut = new GenerateResetPasswordTokenCommandHandler(
            $this->mockedRepository
        );
    }
    public function testShouldThrowExceptionIfUsernameProvidedWrong(): void
    {
        $this->expectException(WrongUsernameException::class);
        ($this->sut)(new GenerateResetPasswordTokenCommand('bad username'));
    }

    public function testShouldThrowExceptionIfUserNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->mockedRepository->method('byUsername')->willThrowException(new UserNotFoundException());
        ($this->sut)($this->command);
    }

    public function testShouldThrowExceptionIfUserPasswordCannotBeResetted(): void
    {
        $this->expectException(PasswordNotReseteableException::class);
        /** @var MockObject|User */
        $failingUser = $this->createMock(User::class);
        $failingUser->method('generateResetPasswordToken')
                    ->willThrowException(new PasswordNotReseteableException());
        $this->mockedRepository->method('byUsername')->willReturn($failingUser);
        ($this->sut)($this->command);
    }

    public function testShouldThrowExceptionIfUserCannotBeUpdated(): void
    {
        $this->expectException(UserRepositoryException::class);
        $this->mockedRepository
             ->method('update')
             ->willThrowException(new UserRepositoryException());
        ($this->sut)($this->command);
    }

    public function testShouldFinishExecutionWhenNoErrors(): void
    {
        ($this->sut)($this->command);
        $this->assertTrue(true);
    }
}
