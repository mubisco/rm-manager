<?php

declare(strict_types=1);

namespace App\Tests\integration\User\Infrastructure\Mailer;

use App\User\Domain\UserEmail;
use App\User\Domain\Username;
use App\User\Infrastructure\Mailer\SymfonyUserMailer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SymfonyUserMailerIntegrationTest extends KernelTestCase
{
    private SymfonyUserMailer $sut;

    protected function setUp(): void
    {
        $kernel = self::createKernel();
        $kernel->boot();
        $this->sut = $kernel->getContainer()->get('user.mailer');
    }

    /**
     * @test
     */
    public function itShouldSendEmailForWelcomeUser(): void
    {
        $result = $this->sut->sendWelcomeMail(new Username('agapito'), new UserEmail('new.user@test.com'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function itShouldSendPasswordResetEmail(): void
    {
        $result = $this->sut->send('agapito', 'reset.password@test.com', 'token');
        $this->assertTrue($result);
    }
}
