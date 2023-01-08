<?php

namespace App\Tests\unit\User\Application\Command;

use App\Shared\Application\CommandHandlerInterface;
use App\User\Application\Command\ChangePasswordCommand;
use App\User\Application\Command\ChangePasswordCommandHandler;
use App\User\Domain\PasswordChangeException;
use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\User;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangePasswordCommandHandlerTest extends TestCase
{
    private const EXAMPLE_TOKEN = '99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507';
    private const SECURE_PASS = 'aVeryS3cureP4ssw0rd';
    private ChangePasswordCommandHandler $sut;
    private UserRepository&MockObject $userRepository;
    private PasswordEncryptor&MockObject $passwordEncryptor;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->passwordEncryptor = $this->createMock(PasswordEncryptor::class);
        $this->sut = new ChangePasswordCommandHandler($this->userRepository, $this->passwordEncryptor);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(CommandHandlerInterface::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfPasswordNotValid(): void
    {
        $this->expectException(PasswordChangeException::class);
        ($this->sut)(new ChangePasswordCommand(self::EXAMPLE_TOKEN, 'asd'));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfWrongToken(): void
    {
        $this->expectException(PasswordChangeException::class);
        ($this->sut)(new ChangePasswordCommand('fakeToken', self::SECURE_PASS));
    }
    /**
     * @test
     */
    public function itShouldThrowExceptionIfNoUserFound(): void
    {
        $this->expectException(PasswordChangeException::class);
        $this->userRepository->method('ofValidPasswordToken')->willThrowException(new PasswordTokenNotFoundException());
        ($this->sut)(new ChangePasswordCommand(self::EXAMPLE_TOKEN, self::SECURE_PASS));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfPasswordTokenExpired(): void
    {
        $this->expectException(PasswordChangeException::class);
        $this->userRepository->method('ofValidPasswordToken')->willThrowException(new PasswordTokenExpiredException());
        ($this->sut)(new ChangePasswordCommand(self::EXAMPLE_TOKEN, self::SECURE_PASS));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfPasswordCannotBeUpdated(): void
    {
        $this->expectException(PasswordChangeException::class);
        /** @var User|MockObject */
        $mockedUser = $this->createMock(User::class);
        $mockedUser->method('updatePassword')->willThrowException(new PasswordChangeException());
        $this->userRepository->method('ofValidPasswordToken')->willReturn($mockedUser);
        ($this->sut)(new ChangePasswordCommand(self::EXAMPLE_TOKEN, self::SECURE_PASS));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfUpdatedUserCannotBeStored(): void
    {
        $this->expectException(PasswordChangeException::class);
        $this->userRepository->method('update')->willThrowException(new UserRepositoryException());
        ($this->sut)(new ChangePasswordCommand(self::EXAMPLE_TOKEN, self::SECURE_PASS));
    }

    /**
     * @test
     */
    public function itShouldCompleteIfNoErrors(): void
    {
        ($this->sut)(new ChangePasswordCommand(self::EXAMPLE_TOKEN, self::SECURE_PASS));
        $this->assertTrue(true);
    }
}
