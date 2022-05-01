<?php

namespace App\User\Domain;

use InvalidArgumentException;

class WrongPasswordFormatException extends InvalidArgumentException
{
}
