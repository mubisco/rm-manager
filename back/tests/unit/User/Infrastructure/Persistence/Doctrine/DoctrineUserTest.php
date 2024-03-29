<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\PasswordChangeException;
use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordEncryptorException;
use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\PasswordTokenWasRequested;
use App\User\Domain\UserPassword;
use App\User\Domain\UserWasCreated;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

class DoctrineUserTest extends TestCase
{
    private DoctrineUser $sut;
    /** @var PasswordEncryptor&MockObject */
    private PasswordEncryptor|MockObject $passwordEncryptor;

    protected function setUp(): void
    {
        $this->passwordEncryptor = $this->createMock(PasswordEncryptor::class);
        $this->sut = new DoctrineUser('some@email.net', 'existinguser', 'password', ['ROLE_USER'], null, null);
    }

    public function testShouldReturnProperValues(): void
    {
        $this->assertEquals($this->sut->user(), 'existinguser');
        $this->assertEquals('existinguser', $this->sut->getUsername());
        $this->assertEquals('existinguser', $this->sut->getUserIdentifier());
        $this->assertEquals($this->sut->passwordResetToken(), '');
        $this->assertEquals($this->sut->passwordResetTokenDate(), '');
        $this->assertTrue(Ulid::isValid($this->sut->userId()->value()));
        $events = $this->sut->pullEvents();
        $this->assertInstanceOf(UserWasCreated::class, $events[0]);
        $event = $events[0];
        $this->assertEquals($this->sut->userId()->value(), $event->userId);
        $this->assertEquals('some@email.net', $event->mail);
        $this->assertEquals('existinguser', $event->name);
        $this->assertEquals(
            '{"userId":"' . $this->sut->userId()->value() . '","name":"existinguser","mail":"some@email.net"}',
            $event->__toString()
        );
        $now = new DateTimeImmutable();
        $this->assertEquals($now->format('Y-m-d H'), $event->occurredOn()->format('Y-m-d H'));
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
        $events = $this->sut->pullEvents();
        $this->sut->generateResetPasswordToken();
        $events = $this->sut->pullEvents();
        $this->assertNotEmpty($events);
        $this->assertInstanceOf(PasswordTokenWasRequested::class, $events[0]);
        /** @var PasswordTokenWasRequested */
        $event = $events[0];
        $this->assertEquals($this->sut->userId()->value(), $event->userId());
        $this->assertEmpty($this->sut->pullEvents());
    }

    /**
     * @test
     */
    public function itShouldReturnTrueIfTokenIsExpired(): void
    {
        $expiredTokenUser = new DoctrineUser(
            'expired@token.net',
            'expiredTokenUser',
            'password',
            ['ROLE_USER'],
            '99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507',
            new DateTimeImmutable('2020-12-12')
        );
        $this->assertTrue($expiredTokenUser->isTokenExpired());
    }

    /**
     * @test
     */
    public function itShouldReturnFalseIfTokenIsExpired(): void
    {
        $expiredTokenUser = new DoctrineUser(
            'reseteable@token.net',
            'validTokenUser',
            'password',
            ['ROLE_USER'],
            '10c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507',
            new DateTimeImmutable()
        );
        $this->assertFalse($expiredTokenUser->isTokenExpired());
    }

    /**
     * @test
     */
    public function itShouldReturnTokenExpiredTrueIfNoTokenDefined(): void
    {
        $this->assertTrue($this->sut->isTokenExpired());
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfPasswordCannotBeUpdated(): void
    {
        $this->expectException(PasswordChangeException::class);
        $this->passwordEncryptor->method('encryptPassword')->willThrowException(new PasswordEncryptorException());
        $this->sut->updatePassword($this->passwordEncryptor, new UserPassword('sz3curePassword'));
    }

    /**
     * @test
     */
    public function itShouldUpdatePasswordProperly(): void
    {
        $this->passwordEncryptor->method('encryptPassword')->willReturn('updatedPassword');
        $this->sut->generateResetPasswordToken();
        $this->sut->updatePassword($this->passwordEncryptor, new UserPassword('sz3curePassword'));
        $updatedPassword = $this->sut->getPassword();
        $this->assertEquals('updatedPassword', $updatedPassword);
        $this->assertEquals('', $this->sut->passwordResetToken());
        $this->assertEquals(null, $this->sut->passwordResetTokenDate());
    }
}
