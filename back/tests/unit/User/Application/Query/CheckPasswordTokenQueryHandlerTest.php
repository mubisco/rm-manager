<?php

namespace App\Tests\unit\User\Application\Query;

use App\Shared\Application\QueryHandlerInterface;
use App\User\Application\Query\CheckPasswordTokenQuery;
use App\User\Application\Query\CheckPasswordTokenQueryHandler;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\UserRepository;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CheckPasswordTokenQueryHandlerTest extends TestCase
{
    private const EXAMPLE_TOKEN = '99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507';
    private CheckPasswordTokenQueryHandler $sut;
    private UserRepository&MockObject $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->sut = new CheckPasswordTokenQueryHandler($this->userRepository);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(CheckPasswordTokenQueryHandler::class, $this->sut);
        $this->assertInstanceOf(QueryHandlerInterface::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenTokenHasWrongFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ($this->sut)(new CheckPasswordTokenQuery('-invalid token'));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenTokenNotFound(): void
    {
        $this->expectException(PasswordTokenNotFoundException::class);
        $this->userRepository->method('ofValidPasswordToken')->willThrowException(new PasswordTokenNotFoundException());
        ($this->sut)(new CheckPasswordTokenQuery(self::EXAMPLE_TOKEN));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenTokenIsExpired(): void
    {
        $this->expectException(PasswordTokenExpiredException::class);
        $this->userRepository->method('ofValidPasswordToken')->willThrowException(new PasswordTokenExpiredException());
        ($this->sut)(new CheckPasswordTokenQuery(self::EXAMPLE_TOKEN));
    }
    /**
     * @test
     */
    public function itShouldReturnTrueIfTokenOk(): void
    {
        $result = ($this->sut)(new CheckPasswordTokenQuery(self::EXAMPLE_TOKEN));
        $this->assertTrue($result);
    }
}
