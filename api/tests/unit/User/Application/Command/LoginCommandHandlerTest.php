<?php

namespace App\User\Application\Command;

use App\User\Domain\UnauthorizedUserException;
use App\User\Domain\User;
use App\User\Domain\UserRepository;
use App\User\Domain\WrongPasswordFormatException;
use App\User\Domain\WrongUserEmailException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LoginCommandHandlerTest extends TestCase
{
    private LoginCommandHandler $sut;
    private LoginCommand $command;
    private UserRepository|MockObject $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->command = new LoginCommand('one.mail@server.net', 'anyPassword');
        $this->sut = new LoginCommandHandler($this->userRepository);
    }

    public function testShouldThrowInvalidArgumentExceptionIfWrongEmail(): void
    {
        $this->expectException(WrongUserEmailException::class);
        ($this->sut)(new LoginCommand('one.mailserver.net', 'somePassword'));
    }
    public function testShouldThrowExceptionIfWrongPassword(): void
    {
        $this->expectException(WrongPasswordFormatException::class);
        ($this->sut)(new LoginCommand('one.mail@server.net', 'wrongPassword'));
    }
    public function testShouldThrowUnauthorizedException(): void
    {
        $this->expectException(UnauthorizedUserException::class);
        $this->userRepository
             ->method('login')
             ->willThrowException(new UnauthorizedUserException('Mecachis'));
        ($this->sut)($this->command);
    }
    public function testShouldReturnDtoIfUserFound(): void
    {
        /** @var User|MockObject */
        $mockedUser = $this->createMock(User::class);
        $mockedUser->method('user')->willReturn('chindasvinto');
        $this->userRepository
             ->method('login')
             ->willReturn($mockedUser);
        $result = ($this->sut)($this->command);
        $this->assertInstanceOf(LoginDto::class, $result);
        $this->assertEquals('chindasvinto', $result->user);
    }
}
