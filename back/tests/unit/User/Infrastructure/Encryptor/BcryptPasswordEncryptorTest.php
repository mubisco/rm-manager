<?php

namespace App\Tests\unit\User\Infrastructure\Encryptor;

use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordEncryptorException;
use App\User\Domain\UserPassword;
use App\User\Infrastructure\Encryptor\BcryptPasswordEncryptor;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BcryptPasswordEncryptorTest extends TestCase
{
    private BcryptPasswordEncryptor $sut;
    private UserPasswordHasherInterface|MockObject $hasher;

    protected function setUp(): void
    {
        $this->hasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->sut = new BcryptPasswordEncryptor($this->hasher);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(BcryptPasswordEncryptor::class, $this->sut);
        $this->assertInstanceOf(PasswordEncryptor::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfCannotEncryptPassword(): void
    {
        $this->expectException(PasswordEncryptorException::class);
        $this->hasher->method('hash')->willThrowException(new InvalidPasswordException());
        $this->sut->encryptPassword(
            new DoctrineUser('ome@email.net', 'oneUsername', 'password', ['ROLE_USER'], null, null),
            new UserPassword('v3rySecret')
        );
    }

    /**
     * @test
     */
    public function itShouldEncryptPassword(): void
    {
        $this->hasher->method('hash')->willReturn('hashedPassword');
        $result = $this->sut->encryptPassword(
            new DoctrineUser('ome@email.net', 'oneUsername', 'password', ['ROLE_USER'], null, null),
            new UserPassword('v3rySecret')
        );
        $this->assertEquals('hashedPassword', $result);
    }
}
