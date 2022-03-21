<?php

namespace App\User\Infrastructure\EntryPoint\Api;

use App\User\Application\Command\LoginCommand;
use App\User\Application\Command\LoginDto;
use App\User\Domain\UnauthorizedUserException;
use App\User\Domain\WrongUserEmailException;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class LoginControllerTest extends TestCase
{
    private LoginController $sut;
    private MessageBusInterface|MockObject $messengerBusInterface;

    protected function setUp(): void
    {
        $this->messengerBusInterface = $this->createMock(MessageBusInterface::class);
        $this->sut = new LoginController($this->messengerBusInterface);
    }
    public function testShouldThrowInvalidArgumentException(): void
    {
        $request = $this->buildRequest('some.email@server.net', 'anyPassword');
        $command = new LoginCommand('some.email@server.net', 'anyPassword');
        $this->messengerBusInterface
            ->method('dispatch')
            ->with($command)
            ->willThrowException(new WrongUserEmailException('Mecachis'));
        $result = $this->sut->login($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(400, $result->getStatusCode());
        $this->assertEquals('{"message":"BAD_PARAMS"}', $result->getContent());
    }
    public function testShouldThrowUnauthorizedException(): void
    {
        $request = $this->buildRequest('some.email@server.net', 'anyPassword');
        $command = new LoginCommand('some.email@server.net', 'anyPassword');
        $this->messengerBusInterface
            ->method('dispatch')
            ->with($command)
            ->willThrowException(new UnauthorizedUserException('Mecachis'));
        $result = $this->sut->login($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(403, $result->getStatusCode());
        $this->assertEquals('{"message":"UNAUTHORIZED_USER"}', $result->getContent());
    }
    public function testShouldReturnAcceptedStatus(): void
    {
        $request = $this->buildRequest('another.email@server.net', 'validPassword');
        $command = new LoginCommand('another.email@server.net', 'validPassword');
        $this->messengerBusInterface
             ->method('dispatch')
             ->with($command)
             ->willReturn(new Envelope(new LoginDto('chindasvinto', 'ADMIN', 'aVeryLargeToken')));
        $result = $this->sut->login($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals(
            '{"user":"chindasvinto","role":"ADMIN","token":"aVeryLargeToken"}',
            $result->getContent()
        );
    }

    private function buildRequest(string $email, string $password): Request
    {
        return new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            '{"email": "' . $email . '", "password": "' . $password . '"}'
        );
    }
}
