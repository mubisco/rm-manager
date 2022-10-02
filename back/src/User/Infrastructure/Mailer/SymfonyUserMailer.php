<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Mailer;

use App\User\Domain\UserEmail;
use App\User\Domain\Username;
use App\User\Domain\WelcomeUserMailer;
use App\User\Domain\WelcomeUserMailerException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

final class SymfonyUserMailer implements WelcomeUserMailer
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }
    public function sendWelcomeMail(Username $username, UserEmail $userEmail): bool
    {
        $email = (new TemplatedEmail())
            ->from('rpgmanager@mubisco.com')
            ->to($userEmail->value())
            ->subject('Thanks for signging up')
            ->htmlTemplate('emails/signup.html.twig')
            ->context(['username' => $username->value()]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new WelcomeUserMailerException($e->getMessage(), $e->getCode(), $e);
        }
        return true;
    }
}
