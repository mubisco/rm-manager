<?php

namespace App\Tests\unit\User\Infrastructure\EntryPoint\Api;

use App\User\Application\Query\CheckPasswordTokenQueryHandler;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Infrastructure\EntryPoint\Api\CheckPasswordTokenController;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CheckPasswordControllerTest extends TestCase
{
    private CheckPasswordTokenController $sut;
    private CheckPasswordTokenQueryHandler|MockObject $queryHandler;

    protected function setUp(): void
    {
        $this->queryHandler = $this->createStub(CheckPasswordTokenQueryHandler::class);
        $this->sut = new CheckPasswordTokenController(
            $this->queryHandler
        );
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(CheckPasswordTokenController::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldReturn404ResponseWhenTokenDoesNotExists(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new PasswordTokenNotFoundException());
        $response = ($this->sut)('aNot3xistingT0ken');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function itShouldReturn400ResponseWhenTokenExpired(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new PasswordTokenExpiredException());
        $response = ($this->sut)('an3xp1r3dT0ken');
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function itShouldReturn404IfBadTokenFormat(): void
    {
        $this->queryHandler->method('__invoke')->willThrowException(new InvalidArgumentException());
        $response = ($this->sut)('an3xp1r3dT0ken');
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function itShouldReturn200StatusCodeIfTokenOk(): void
    {
        $response = ($this->sut)('an3xp1r3dT0ken');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
