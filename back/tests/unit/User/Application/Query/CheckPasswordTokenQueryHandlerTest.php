<?php

namespace App\Tests\unit\User\Application\Query;

use App\Shared\Application\QueryHandlerInterface;
use App\User\Application\Query\CheckPasswordTokenQueryHandler;
use App\User\Domain\PasswordTokenNotFoundException;
use PHPUnit\Framework\TestCase;

class CheckPasswordTokenQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new CheckPasswordTokenQueryHandler();
        $this->assertInstanceOf(CheckPasswordTokenQueryHandler::class, $sut);
        $this->assertInstanceOf(QueryHandlerInterface::class, $sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenTokenNotFound(): void
    {
        $this->expectException(PasswordTokenNotFoundException::class);
        $sut = new CheckPasswordTokenQueryHandler();
        ($sut)();
    }
}
