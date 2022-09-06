<?php

namespace App\Tests\unit\User\Infrastructure\EntryPoint\Console;

use App\User\Domain\UserFactoryException;
use App\User\Infrastructure\EntryPoint\Console\DoctrineUserConsoleCommandFactory;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DoctrineUserConsoleCommandFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new DoctrineUserConsoleCommandFactory();
        $this->assertInstanceOf(DoctrineUserConsoleCommandFactory::class, $sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfDataEmpty(): void
    {
        $this->expectException(UserFactoryException::class);
        $sut = new DoctrineUserConsoleCommandFactory();
        $sut->make([]);
    }

    /**
     * @test
     */
    public function itShouldReturnDoctrineUser(): void
    {
        $sut = new DoctrineUserConsoleCommandFactory();
        $result = $sut->make([
            'name' => 'agapito',
            'mail' => 'test@test.com',
            'password' => 'simple-password',
            'role' => ['ROLE_USER']
        ]);
        $this->assertInstanceOf(DoctrineUser::class, $result);
    }

    /**
     * @test
     */
    public function itShouldReturnProperData(): void
    {
        $sut = new DoctrineUserConsoleCommandFactory();
        /** @var DoctrineUser */
        $result = $sut->make([
            'name' => 'agapito',
            'mail' => 'test@test.com',
            'password' => 'simple-password',
            'role' => ['ROLE_USER']
        ]);
        $this->assertEquals('agapito', $result->user());
        $this->assertEquals('test@test.com', $result->mail());
        $this->assertEquals(['ROLE_USER'], $result->getRoles());
    }

    /**
     * @test
     */
    public function itShouldCreateUserRoleWhenNoRoleDefined(): void
    {
        $sut = new DoctrineUserConsoleCommandFactory();
        /** @var DoctrineUser */
        $result = $sut->make([
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
        $sut = new DoctrineUserConsoleCommandFactory();
        /** @var DoctrineUser */
        $sut->make([
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
        $sut = new DoctrineUserConsoleCommandFactory();
        /** @var DoctrineUser */
        $sut->make([
            'name' => 'agapito',
            'password' => 'simple-password',
            'role' => ['asd']
        ]);
    }
}
