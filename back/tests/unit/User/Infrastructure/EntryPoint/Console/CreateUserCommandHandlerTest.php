<?php

namespace App\Tests\unit\User\Infrastructure\EntryPoint\Console;

use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Command\CreateUserCommandHandler;
use App\User\Domain\UserFactory;
use App\User\Domain\UserFactoryException;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use App\User\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserCommandHandlerTest extends TestCase
{
    private CreateUserCommandHandler $sut;
    private UserFactory|MockObject $userFactory;
    private InMemoryUserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userFactory = $this->createMock(UserFactory::class);
        $this->userRepository = new InMemoryUserRepository();
        $this->sut = new CreateUserCommandHandler(
            $this->userFactory,
            $this->userRepository
        );
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenDataNotValid(): void
    {
        $this->expectException(UserFactoryException::class);
        $this->userFactory->method('make')->willThrowException(new UserFactoryException());
        ($this->sut)(new CreateUserCommand([]));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfUserCannotBeStored(): void
    {
        $this->expectException(UserRepositoryException::class);
        /** @var UserRepository|MockObject */
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('store')->willThrowException(new UserRepositoryException());
        $sut = new CreateUserCommandHandler(
            $this->userFactory,
            $userRepository
        );
        ($sut)(new CreateUserCommand([]));
    }

    /**
     * @test
     */
    public function itShouldCreateUserProperly(): void
    {
        $user = new DoctrineUser('test@test.com', 'username', 'password', ['ROLE_USER'], null, null);
        $this->userFactory->method('make')->willReturn($user);
        ($this->sut)(new CreateUserCommand([]));
        $storedUser = $this->userRepository->ofId($user->userId());
        $this->assertSame($user, $storedUser);
    }
}
