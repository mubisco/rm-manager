<?php

namespace App\Tests\unit\User\Infrastructure\EntryPoint\Console;

use App\User\Domain\UserFactoryException;
use App\User\Infrastructure\EntryPoint\Console\DoctrineUserConsoleCommandFactory;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DoctrineUserConsoleCommandFactoryTest extends TestCase
{
    private DoctrineUserConsoleCommandFactory $sut;
    private UserPasswordHasherInterface|MockObject $hasher;

    protected function setUp(): void
    {
        $this->hasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->sut = new DoctrineUserConsoleCommandFactory(
            $this->hasher
        );
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(DoctrineUserConsoleCommandFactory::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfDataEmpty(): void
    {
        $this->expectException(UserFactoryException::class);
        $this->sut->make([]);
    }

    /**
     * @test
     */
    public function itShouldReturnDoctrineUser(): void
    {
        $this->hasher->method('hashPassword')->willReturn('hashedPassword');
        /** @var DoctrineUser */
        $result = $this->sut->make([
            'name' => 'agapito',
            'mail' => 'test@test.com',
            'password' => 'simple-password',
            'role' => ['ROLE_USER']
        ]);
        $this->assertInstanceOf(DoctrineUser::class, $result);
        $this->assertEquals('agapito', $result->user());
        $this->assertEquals('test@test.com', $result->mail());
        $this->assertEquals(['ROLE_USER'], $result->getRoles());
        $this->assertEquals('hashedPassword', $result->getPassword());
    }

    /**
     * @test
     */
    public function itShouldCreateUserRoleWhenNoRoleDefined(): void
    {
        /** @var DoctrineUser */
        $result = $this->sut->make([
            'name' => 'agapito',
            'mail' => 'test@test.com',
            'password' => 'simple-password'
        ]);
        $this->assertEquals(['ROLE_USER'], $result->getRoles());
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfWrongRoles(): void
    {
        $this->expectException(UserFactoryException::class);
        /** @var DoctrineUser */
        $this->sut->make([
            'name' => 'agapito',
            'mail' => 'test@test.com',
            'password' => 'simple-password',
            'role' => ['asd']
        ]);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfMandatoryParamsNotPresent(): void
    {
        $this->expectException(UserFactoryException::class);
        /** @var DoctrineUser */
        $this->sut->make([
            'name' => 'agapito',
            'password' => 'simple-password',
            'role' => ['asd']
        ]);
    }
}
