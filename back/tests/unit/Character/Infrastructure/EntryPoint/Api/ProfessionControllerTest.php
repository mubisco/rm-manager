<?php

namespace App\Tests\unit\Character\Infrastructure\EntryPoint\Api;

use App\Character\Application\Profession\Query\FindProfessionByCodeQueryHandler;
use App\Character\Domain\Profession\ProfessionNotFoundException;
use App\Character\Infrastructure\EntryPoint\Api\ProfessionController;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ProfessionControllerTest extends TestCase
{
    private ProfessionController $sut;
    private FindProfessionByCodeQueryHandler&Stub $queryHandler;

    protected function setUp(): void
    {
        $this->queryHandler = $this->createStub(FindProfessionByCodeQueryHandler::class);
        $this->sut = new ProfessionController($this->queryHandler);
    }

    /** @test */
    public function itShouldReturnProperCodeWhenBadProfessionCode(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new InvalidArgumentException());
        $result = $this->sut->getByCode('es', 'some-profession');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $result->getStatusCode());
    }

    /** @test */
    public function itShouldReturnProperCodeWhenProfessionNotFound(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new ProfessionNotFoundException());
        $result = $this->sut->getByCode('es', 'cleric');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $result->getStatusCode());
    }

    /** @test */
    public function itShouldReturnProperResponseWhenProfessionFound(): void
    {
        $expectedResponse = ['asd' => 'asd'];
        $this->queryHandler->method('__invoke')->willReturn($expectedResponse);
        $result = $this->sut->getByCode('es', 'cleric');
        $this->assertEquals(Response::HTTP_OK, $result->getStatusCode());
        $this->assertEquals(json_encode($expectedResponse), $result->getContent());
    }
}
