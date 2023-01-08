<?php

namespace App\Tests\unit\User\Infrastructure\EntryPoint\Api;

use App\User\Application\Command\ChangePasswordCommandHandler;
use App\User\Domain\PasswordChangeException;
use App\User\Infrastructure\EntryPoint\Api\ChangePasswordController;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ChangePasswordControllerTest extends TestCase
{
    private ChangePasswordController $sut;
    private ChangePasswordCommandHandler&MockObject $commandHandler;
    private Request $request;

    protected function setUp(): void
    {
        $rawRequestData = ['token' => 'token', 'password' => 'n3wSecurePassword'];
        $requestData = json_encode($rawRequestData);
        $this->request = Request::create(
            '/api/user/password/change',
            'PATCH',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            $requestData ? $requestData : ''
        );
        $this->commandHandler = $this->createMock(ChangePasswordCommandHandler::class);
        $this->sut = new ChangePasswordController($this->commandHandler);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(ChangePasswordController::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldReturn500ErrorResponseIfPasswordNotChanged(): void
    {
        $this->commandHandler->method('__invoke')->willThrowException(new PasswordChangeException());
        $response = ($this->sut)($this->request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function itShouldReturn200IfPasswordChanged(): void
    {
        $response = ($this->sut)($this->request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
