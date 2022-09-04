<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\PasswordTokenWasRequested;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

class DoctrineUserTest extends TestCase
{
    private DoctrineUser $sut;

    protected function setUp(): void
    {
        $this->sut = new DoctrineUser('some@email.net', 'existinguser', 'password', ['ROLE_USER'], null, null);
    }
    public function testShouldReturnProperValues()
    {
        $this->assertEquals($this->sut->user(), 'existinguser');
        $this->assertEquals($this->sut->passwordResetToken(), '');
        $this->assertEquals($this->sut->passwordResetTokenDate(), '');
        $this->assertTrue(Ulid::isValid($this->sut->userId()->value()));
        $this->assertEmpty($this->sut->pullEvents());
    }

    public function testShouldThrowExceptionIfPasswordTokenCannotBeReseted(): void
    {
        $this->expectException(PasswordNotReseteableException::class);
        $sut = new DoctrineUser('some@email.net', 'existinguser', '', ['ROLE_USER'], null, null);
        $sut->generateResetPasswordToken();
    }

    public function testShouldGeneratePasswordResetTokenProperly(): void
    {
        $result = $this->sut->generateResetPasswordToken();
        $this->assertTrue(preg_match("/^([a-f0-9]{64})$/", $result) == 1);
        $this->assertEquals($result, $this->sut->passwordResetToken());
        $now = new DateTime();
        $this->assertStringContainsString($now->format('Y-m-d H:i'), $this->sut->passwordResetTokenDate());
    }

    public function testShouldGenerateEventWhenPasswordReset(): void
    {
        $this->sut->generateResetPasswordToken();
        $events = $this->sut->pullEvents();
        $this->assertNotEmpty($events);
        $this->assertInstanceOf(PasswordTokenWasRequested::class, $events[0]);
        /** @var PasswordTokenWasRequested */
        $event = $events[0];
        $this->assertEquals($this->sut->userId()->value(), $event->userId());
        $this->assertEmpty($this->sut->pullEvents());
    }
}
