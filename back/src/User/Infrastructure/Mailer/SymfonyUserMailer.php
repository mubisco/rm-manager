<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Mailer;

use App\User\Domain\PasswordTokenMailer;
use App\User\Domain\PasswordTokenMailerException;
use App\User\Domain\UserEmail;
use App\User\Domain\Username;
use App\User\Domain\WelcomeUserMailer;
use App\User\Domain\WelcomeUserMailerException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

final class SymfonyUserMailer implements WelcomeUserMailer, PasswordTokenMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private string $frontBaseUrl
    ) {
    }
    public function sendWelcomeMail(Username $username, UserEmail $userEmail): bool
    {
        $email = (new TemplatedEmail())
            ->from('rpgmanager@mubisco.com')
            ->to($userEmail->value())
            ->subject('Thanks for signing up')
            ->htmlTemplate('emails/signup.html.twig')
            ->context(['username' => $username->value(), 'frontUrl' => $this->frontBaseUrl]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new WelcomeUserMailerException($e->getMessage(), $e->getCode(), $e);
        }
        return true;
    }

    public function send(string $username, string $mailer, string $token): bool
    {
        $email = (new TemplatedEmail())
            ->from('rpgmanager@mubisco.com')
            ->to($mailer)
            ->subject('Reset password requested')
            ->htmlTemplate('emails/reset.password.html.twig')
            ->context([
                'username' => $username,
                'tokenUrl' => $this->frontBaseUrl . '/reset-password/' . $token
            ]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new PasswordTokenMailerException($e->getMessage(), $e->getCode(), $e);
        }
        return true;
    }
}
