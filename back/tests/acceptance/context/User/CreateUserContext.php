<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\Username;
use App\User\Domain\UserRepository;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\TraceableMessageBus;

final class CreateUserContext implements Context
{
    private Application $application;
    private BufferedOutput $output;
    private UserRepository $userRepository;
    private TraceableMessageBus $transport;

    private string $userName = '';
    private string $mail = '';
    private array $roles = [];

    public function __construct(private KernelInterface $kernel)
    {
        $this->application = new Application($kernel);
        $this->output = new BufferedOutput();
        $this->userRepository = $kernel->getContainer()->get('test.userRepository');
        $this->transport = $kernel->getContainer()->get('messenger.default_bus');
    }
    /**
     * @Given A sys admin with console access
     */
    public function aSysAdminWithConsoleAccess()
    {
        Assert::assertSame('cli', php_sapi_name());
    }

    /**
     * @When I create a user with name :name, mail :mail, password :password and role :role
     */
    public function iCreateAUserWithNameMailPasswordAndRole(
        string $name,
        string $mail,
        string $password,
        string $role
    ): void {
        $this->userName = $name;
        $this->mail = $mail;
        $this->roles[] = $role;
        $command = "user:create";
        $input = new ArgvInput([
            'dummy-placeholder',
            $command,
            $name,
            $mail,
            $password,
            "--role={$role}",
            "--env=test"
        ]);
        $this->application->doRun($input, $this->output);
    }

    /**
     * @Then I should see :expectedMessage message
     */
    public function iShouldSeeMessage(string $expectedMessage): void
    {
        $output = $this->output->fetch();
        Assert::assertStringContainsString($expectedMessage, $output);
    }

    /**
     * @Then I should have a user with proper data
     */
    public function iShouldHaveAUserWithProperData()
    {
        /** @var DoctrineUser */
        $createdUser = $this->userRepository->byUsername(new Username($this->userName));
        Assert::assertEquals($this->mail, $createdUser->mail());
        $roles = $createdUser->getRoles();
        Assert::assertEquals($roles, $this->roles);
    }

    /**
     * @Then One event must be dispatched
     */
    public function oneEventMustBeDispatched()
    {
        Assert::assertCount(1, $this->transport->getDispatchedMessages());
    }
}
