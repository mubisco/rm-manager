<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\User\Domain\PasswordTokenMailer;
use App\User\Domain\PasswordTokenWasRequested;
use App\User\Domain\UserId;
use App\User\Domain\UserRepository;

final class SendPasswordTokenEventHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordTokenMailer $passwordTokenMailer
    ) {
    }

    public function __invoke(PasswordTokenWasRequested $event): void
    {
        $userId = UserId::fromString($event->userId());
        $user = $this->userRepository->ofId($userId);
        $this->passwordTokenMailer->send(
            $user->user(),
            $user->mail(),
            $user->passwordResetToken()
        );
    }
}
