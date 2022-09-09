<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\Shared\Application\EventHandlerInterface;
use App\User\Domain\UserEmail;
use App\User\Domain\Username;
use App\User\Domain\UserWasCreated;
use App\User\Domain\WelcomeUserMailer;

final class UserCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(private WelcomeUserMailer $mailer)
    {
    }
    public function __invoke(UserWasCreated $event): void
    {
        $username = new Username($event->name);
        $usermail = new UserEmail($event->mail);
        $this->mailer->sendWelcomeMail($username, $usermail);
    }
}
