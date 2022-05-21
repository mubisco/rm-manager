<?php

namespace App\User\Infrastructure\EntryPoint\Api;

use App\User\Application\Command\GenerateResetPasswordTokenCommand;
use App\User\Application\Command\GenerateResetPasswordTokenCommandHandler;
use App\User\Domain\UserNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UserApiControllerTest extends TestCase
{
    public function testShouldGenerateResetPasswordToken(): void
    {
        /** @var MockObject|GenerateResetPasswordTokenCommandHandler */
        $mockedCommandHandler = $this->createStub(GenerateResetPasswordTokenCommandHandler::class);
        $command = new GenerateResetPasswordTokenCommand('existantUser');
        $mockedCommandHandler->expects($this->once())->method('__invoke')->with($command);
        $sut = new UserApiController($mockedCommandHandler);
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode(['username' => 'existantUser'], JSON_THROW_ON_ERROR)
        );
        $response = $sut->resetPassword($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
    /*
    public function testShouldReturn404CodeIfUsernameDoesNotExists(): void
    {
        /** @var MockObject|GenerateResetPasswordTokenCommandHandler
        $mockedCommandHandler = $this->createMock(GenerateResetPasswordTokenCommandHandler::class);
        $mockedCommandHandler
            ->expects($this->once())
            ->method('__invoke')
            ->willThrowException(new UserNotFoundException());
        $sut = new UserApiController($mockedCommandHandler);
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode(['username' => 'anyUser'], JSON_THROW_ON_ERROR)
        );
        $response = $sut->resetPassword($request);
        $this->assertEquals(404, $response->getStatusCode());
    }
     */
}
