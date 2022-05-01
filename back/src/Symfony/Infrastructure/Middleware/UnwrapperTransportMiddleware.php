<?php

namespace App\Symfony\Infrastructure\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;
use Throwable;

final class UnwrapperTransportMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (HandlerFailedException $exception) {
            $nestedException = $this->getNestedException($exception);

            if ($nestedException === null) {
                throw $exception;
            }
            throw $nestedException;
        }
    }

    private function getNestedException(HandlerFailedException $exception): ?Throwable
    {
        $nestedExceptions = $exception->getNestedExceptions();

        if (count($nestedExceptions) === 1) {
            return $nestedExceptions[0];
        }

        return null;
    }

    private function isLastRetry(Envelope $envelope, Throwable $nestedException): bool
    {
        if ($nestedException instanceof UnrecoverableMessageHandlingException) {
            return true;
        }

        /** @var RedeliveryStamp|null $redeliveryStamp */
        $redeliveryStamp = $envelope->last(RedeliveryStamp::class);

        if ($redeliveryStamp === null) {
            return false;
        }

        return $redeliveryStamp->getRetryCount() === $this->maxRetries;
    }
}
