<?php

namespace App\Tests\unit\User\Application\Query;

use App\User\Application\Query\CheckPasswordTokenQuery;
use PHPUnit\Framework\TestCase;

class CheckPasswordTokenQueryTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnProperTokenValue(): void
    {
        $sut = new CheckPasswordTokenQuery('token');
        $this->assertEquals('token', $sut->token());
    }
}
