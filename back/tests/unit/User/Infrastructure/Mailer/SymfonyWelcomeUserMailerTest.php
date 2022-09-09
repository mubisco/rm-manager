<?php

namespace App\Tests\unit\User\Infrastructure\Mailer;

use App\User\Domain\UserEmail;
use App\User\Domain\Username;
use App\User\Domain\WelcomeUserMailer;
use App\User\Domain\WelcomeUserMailerException;
use App\User\Infrastructure\Mailer\SymfonyWelcomeUserMailer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;

class SymfonyWelcomeUserMailerTest extends TestCase
{
    private SymfonyWelcomeUserMailer $sut;
    private MailerInterface|MockObject $mailer;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->sut = new SymfonyWelcomeUserMailer($this->mailer);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(SymfonyWelcomeUserMailer::class, $this->sut);
        $this->assertInstanceOf(WelcomeUserMailer::class, $this->sut);
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
}
