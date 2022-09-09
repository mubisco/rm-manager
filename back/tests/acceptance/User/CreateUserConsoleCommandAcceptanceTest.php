<?php

namespace App\Tests\acceptance\User;

use App\User\Domain\Username;
use App\User\Infrastructure\EntryPoint\Console\CreateUserConsoleCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserConsoleCommandAcceptanceTest extends KernelTestCase
{
    /**
     * @test
     */
    public function asSystemAdminIWantToCreateAUser(): void
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $userRepository = $kernel->getContainer()->get('test.userRepository');
        $commandBus = $kernel->getContainer()->get('messenger.default_bus');

        $application = new Application($kernel);
        $sut = new CreateUserConsoleCommand($commandBus);
        $application->add($sut);

        $command = $application->find('user:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'name' => 'agapito',
            'mail' => 'test@test.com',
            'password' => 'simple-password',
            '--role' => ['ROLE_USER']
        ]);

        $result = $commandTester->getStatusCode();
        $this->assertEquals(Command::SUCCESS, $result);
        $createdUser = $userRepository->byUsername(new Username('agapito'));
        $this->assertEquals('test@test.com', $createdUser->mail());
    }
}
