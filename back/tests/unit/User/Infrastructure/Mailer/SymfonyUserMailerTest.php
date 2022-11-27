<?php

namespace App\Tests\unit\User\Infrastructure\Mailer;

use App\User\Domain\PasswordTokenMailer;
use App\User\Domain\PasswordTokenMailerException;
use App\User\Domain\UserEmail;
use App\User\Domain\Username;
use App\User\Domain\WelcomeUserMailer;
use App\User\Domain\WelcomeUserMailerException;
use App\User\Infrastructure\Mailer\SymfonyUserMailer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;

class SymfonyUserMailerTest extends TestCase
{
    private SymfonyUserMailer $sut;
    private MailerInterface|MockObject $mailer;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->sut = new SymfonyUserMailer($this->mailer, 'https://www.google.es');
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(SymfonyUserMailer::class, $this->sut);
        $this->assertInstanceOf(WelcomeUserMailer::class, $this->sut);
        $this->assertInstanceOf(PasswordTokenMailer::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfMailerFails(): void
    {
        $this->expectException(WelcomeUserMailerException::class);
        $this->mailer->method('send')->willThrowException(new TransportException('asd'));
        $this->sut->sendWelcomeMail(new Username('agapito'), new UserEmail('test@test.com'));
    }

    /**
     * @test
     */
    public function itShouldReturnTrueIfMailSent(): void
    {
        $result = $this->sut->sendWelcomeMail(new Username('agapito'), new UserEmail('test@test.com'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfMailerFailsWhenSendingResetPasswordMail(): void
    {
        $this->expectException(PasswordTokenMailerException::class);
        $this->mailer->method('send')->willThrowException(new TransportException('asd'));
        $this->sut->send('agapito', 'test@test.com', 'aToken');
    }

    /**
     * @test
     */
    public function itShouldReturnTrueIfMailSentWhenSendingResetPasswordMail(): void
    {
        $result = $this->sut->send('agapito', 'test@test.com', 'aToken');
        $this->assertTrue($result);
    }
}
