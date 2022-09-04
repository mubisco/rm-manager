<?php

namespace App\Tests\unit\User\Application\Event;

use App\User\Application\Event\SendPasswordTokenEventHandler;
use App\User\Domain\PasswordTokenMailer;
use App\User\Domain\PasswordTokenMailerException;
use App\User\Domain\PasswordTokenWasRequested;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

class SendPasswordTokenEventHandlerTest extends TestCase
{
    private SendPasswordTokenEventHandler $sut;
    private UserRepository|MockObject $userRepository;
    private PasswordTokenMailer|MockObject $tokenMailer;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->tokenMailer = $this->createMock(PasswordTokenMailer::class);
        $this->sut = new SendPasswordTokenEventHandler(
            $this->userRepository,
            $this->tokenMailer
        );
    }

    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(SendPasswordTokenEventHandler::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfUserIdNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $badUserIdEvent = new PasswordTokenWasRequested('asd');
        ($this->sut)($badUserIdEvent);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfUserNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->method('ofId')->willThrowException(new UserNotFoundException());
        $ulid = new Ulid();
        $event = new PasswordTokenWasRequested($ulid->__toString());
        ($this->sut)($event);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfMailCannotBeSent(): void
    {
        $this->expectException(PasswordTokenMailerException::class);
        $this->tokenMailer->method('send')->willThrowException(new PasswordTokenMailerException());
        $ulid = new Ulid();
        $event = new PasswordTokenWasRequested($ulid->__toString());
        ($this->sut)($event);
    }

    /**
     * @test
     */
    public function itShouldSendMailToUser(): void
    {
        $ulid = new Ulid();
        $event = new PasswordTokenWasRequested($ulid->__toString());
        $this->tokenMailer->expects($this->once())->method('send');
        ($this->sut)($event);
    }
}
