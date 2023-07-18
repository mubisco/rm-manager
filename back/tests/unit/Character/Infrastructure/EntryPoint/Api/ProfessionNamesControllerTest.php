<?php

namespace App\Tests\unit\Character\Infrastructure\EntryPoint\Api;

use App\Character\Application\Profession\Query\FindProfessionNamesQueryHandler;
use App\Character\Domain\Profession\ProfessionNamesReadException;
use App\Character\Infrastructure\EntryPoint\Api\ProfessionNamesController;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

class ProfessionNamesControllerTest extends TestCase
{
    private ProfessionNamesController $sut;
    private FindProfessionNamesQueryHandler&Stub $queryHandler;

    protected function setUp(): void
    {
        $this->queryHandler = $this->createStub(FindProfessionNamesQueryHandler::class);
        $this->sut = new ProfessionNamesController($this->queryHandler);
    }

    /** @test */
    public function itShouldReturnErrorResponseWhenQueryFails(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new ProfessionNamesReadException());
        $result = $this->sut->index('en');
        $this->assertEquals(500, $result->getStatusCode());
    }

    /** @test */
    public function itShouldReturnProperMessageWhenLanguageFails(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new InvalidArgumentException());
        $result = $this->sut->index('sd');
        $this->assertEquals(400, $result->getStatusCode());
    }

    /** @test */
    public function itShouldReturnProperResponseCodeWhenSuccess(): void
    {
        $expectedValues = [['asd' => 'asd'], ['qwe' => 'qwe']];
        $this->queryHandler->method('__invoke')->willReturn($expectedValues);
        $result = $this->sut->index('en');
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals(json_encode($expectedValues), $result->getContent());
    }
}
