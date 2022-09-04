<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\PasswordNotReseteableException;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

class DoctrineUserTest extends TestCase
{
    public function testShouldReturnProperValues()
    {
        $sut = new DoctrineUser('some@email.net', 'existinguser', 'password', ['ROLE_USER'], null, null);
        $this->assertEquals($sut->user(), 'existinguser');
        $this->assertEquals($sut->passwordResetToken(), '');
        $this->assertEquals($sut->passwordResetTokenDate(), '');
        $this->assertTrue(Ulid::isValid($sut->userId()->value()));
    }

    public function testShouldThrowExceptionIfPasswordTokenCannotBeReseted(): void
    {
        $this->expectException(PasswordNotReseteableException::class);
        $sut = new DoctrineUser('some@email.net', 'existinguser', '', ['ROLE_USER'], null, null);
        $sut->generateResetPasswordToken();
    }

    public function testShouldGeneratePasswordResetTokenProperly(): void
    {
        $sut = new DoctrineUser('some@email.net', 'existinguser', 'asd', ['ROLE_USER'], null, null);
        $result = $sut->generateResetPasswordToken();
        $this->assertTrue(preg_match("/^([a-f0-9]{64})$/", $result) == 1);
        $this->assertEquals($result, $sut->passwordResetToken());
        $now = new DateTime();
        $this->assertStringContainsString($now->format('Y-m-d H:i'), $sut->passwordResetTokenDate());
    }
}
