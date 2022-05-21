<?php

namespace App\User\Infrastructure\EntryPoint\Api;

use App\User\Application\Command\GenerateResetPasswordTokenCommand;
use App\User\Application\Command\GenerateResetPasswordTokenCommandHandler;
use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepositoryException;
use App\User\Domain\WrongUsernameException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class UserApiControllerTest extends TestCase
{
    private UserApiController $sut;
    private MockObject|GenerateResetPasswordTokenCommandHandler $mockedCommandHandler;

    protected function setUp(): void
    {
        $this->mockedCommandHandler = $this->createStub(GenerateResetPasswordTokenCommandHandler::class);
        $this->sut = new UserApiController($this->mockedCommandHandler);
    }

    public function testShouldGenerateResetPasswordToken(): void
    {
        $command = new GenerateResetPasswordTokenCommand('anyUser');
        $this->mockedCommandHandler->expects($this->once())->method('__invoke')->with($command);
        $request = $this->createRequest();
        $response = $this->sut->resetPassword($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testShouldReturn400CodeIfUsernameNotValid(): void
    {
        $this->setExceptionForCommandHandler(new WrongUsernameException());
        $request = $this->createRequest();
        $response = $this->sut->resetPassword($request);
        $this->assertEquals(400, $response->getStatusCode());
    }
    public function testShouldReturn404CodeIfUsernameDoesNotExists(): void
    {
        $this->setExceptionForCommandHandler(new UserNotFoundException());
        $request = $this->createRequest();
        $response = $this->sut->resetPassword($request);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testShouldReturn500CodeIfPaswordTokenCannotBeCreated(): void
    {
        $this->setExceptionForCommandHandler(new PasswordNotReseteableException());
        $request = $this->createRequest();
        $response = $this->sut->resetPassword($request);
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testShouldReturn500CodeIfUpdatedUserCannotBeStored(): void
    {
        $this->setExceptionForCommandHandler(new UserRepositoryException());
        $request = $this->createRequest();
        $response = $this->sut->resetPassword($request);
        $this->assertEquals(500, $response->getStatusCode());
    }

    private function createRequest(): Request
    {
        return new Request(
            [],
            [],
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode(['username' => 'anyUser'], JSON_THROW_ON_ERROR)
        );
    }

    private function setExceptionForCommandHandler(Throwable $th): void
    {
        $this->mockedCommandHandler
            ->expects($this->once())
            ->method('__invoke')
            ->willThrowException($th);
    }
}
