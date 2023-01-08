<?php

namespace App\User\Application\Command;

use App\Shared\Domain\Event\DomainEvent;
use App\Tests\unit\User\Application\Command\SpyEventBus;
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
    private MockObject&UserRepository $mockedRepository;
    private SpyEventBus $eventBus;

    protected function setUp(): void
    {
        $this->eventBus = new SpyEventBus();
        $this->mockedRepository = $this->createMock(UserRepository::class);
        $this->command = new GenerateResetPasswordTokenCommand('username');
        $this->sut = new GenerateResetPasswordTokenCommandHandler(
            $this->mockedRepository,
            $this->eventBus
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
        $event = $this->createMock(DomainEvent::class);
        /** @var MockObject|User */
        $user = $this->createMock(User::class);
        $user->method('pullEvents')
             ->willReturn([$event]);
        $this->mockedRepository->method('byUsername')->willReturn($user);
        ($this->sut)($this->command);
        $this->assertNotEmpty($this->eventBus->events);
        $this->assertEquals($this->eventBus->events, [$event]);
    }
}
