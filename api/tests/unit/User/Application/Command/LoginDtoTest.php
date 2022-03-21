<?php

namespace App\User\Application\Command;

use App\User\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LoginDtoTest extends TestCase
{
    public function testShouldReturnProperDtoFromUserInterface(): void
    {
        /** @var User|MockObject */
        $mockedUser = $this->createMock(User::class);
        $mockedUser->method('user')->willReturn('chindasvinto');
        $mockedUser->method('role')->willReturn('ADMIN');
        $mockedUser->method('token')->willReturn('aVeryLargeToken');
        $sut = LoginDto::fromUser($mockedUser);
        $this->assertEquals('chindasvinto', $sut->user);
        $this->assertEquals('ADMIN', $sut->role);
        $this->assertEquals('aVeryLargeToken', $sut->token);
    }
}
