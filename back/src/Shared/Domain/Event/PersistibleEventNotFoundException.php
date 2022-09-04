<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use RuntimeException;

final class PersistibleEventNotFoundException extends RuntimeException
{
}
