<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\CommandHandlerInterface;
use App\Shared\Domain\Event\EventBus;
use App\User\Domain\UserFactory;
use App\User\Domain\UserRepository;

final class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserFactory $userFactory,
        private UserRepository $userRepository,
        private EventBus $eventBus
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = $this->userFactory->make($command->data);
        $this->userRepository->store($user);
        $this->eventBus->sendEvents($user->pullEvents());
    }
}
