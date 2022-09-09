<?php

namespace App\Tests\unit\User\Application\Event;

use App\Shared\Application\EventHandlerInterface;
use App\User\Application\Event\UserCreatedEventHandler;
use App\User\Domain\UserWasCreated;
use App\User\Domain\WelcomeUserMailer;
use App\User\Domain\WelcomeUserMailerException;
use App\User\Domain\WrongUserEmailException;
use App\User\Domain\WrongUsernameException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserCreatedEventHandlerTest extends TestCase
{
    private UserCreatedEventHandler $sut;
    private WelcomeUserMailer|MockObject $mailer;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(WelcomeUserMailer::class);
        $this->sut = new UserCreatedEventHandler($this->mailer);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(UserCreatedEventHandler::class, $this->sut);
        $this->assertInstanceOf(EventHandlerInterface::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfUserMailHasWrongFormat(): void
    {
        $this->expectException(WrongUsernameException::class);
        $event = new UserWasCreated('userId', '', 'mail@mail.com');
        ($this->sut)($event);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenUsernameHasWrongFormat(): void
    {
        $this->expectException(WrongUserEmailException::class);
        $event = new UserWasCreated('userId', 'validusername', 'mail.com');
        ($this->sut)($event);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenMailNotSent(): void
    {
        $this->expectException(WelcomeUserMailerException::class);
        $this->mailer->method('sendWelcomeMail')->willThrowException(new WelcomeUserMailerException());
        $event = new UserWasCreated('userId', 'validusername', 'mail@mail.com');
        ($this->sut)($event);
    }

    /**
     * @test
     */
    public function itShouldSendMail(): void
    {
        $event = new UserWasCreated('userId', 'validusername', 'mail@mail.com');
        ($this->sut)($event);
        $this->assertTrue(true);
    }
}
