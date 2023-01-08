<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\Username;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use App\User\Domain\UserRepository;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;

final class ChangePasswordConsoleCommandContext implements Context
{
    private Application $application;
    private BufferedOutput $output;
    private int $result = -1;
    private UserRepository $userRepository;

    public function __construct(KernelInterface $kernel)
    {
        $this->application = new Application($kernel);
        $this->output = new BufferedOutput();
        /**
         * @var UserRepository
         * @phpstan-ignore-next-line
         **/
        $userRepository = $kernel->getContainer()->get('test.userRepository');
        $this->userRepository = $userRepository;
    }
    /**
     * @When I try to update password of a non existing user
     */
    public function iTryToUpdatePasswordOfANonExistingUser(): void
    {
        $command = "user:password:change";
        $input = new ArgvInput([
            'dummy-placeholder',
            $command,
            'segismundo',
            'New4password',
            "--env=test"
        ]);
        $this->result = $this->application->doRun($input, $this->output);
    }

    /**
     * @Then I should get an error
     */
    public function iShouldGetAnError(): void
    {
        Assert::assertEquals($this->result, 1);
    }

    /**
     * @When I try to update password of an existing user
     */
    public function iTryToUpdatePasswordOfAnExistingUser(): void
    {
        $user = new DoctrineUser(
            'test@user.com',
            'testuser',
            'password',
            ['ROLE_USER'],
            null,
            null
        );
        $this->userRepository->store($user);
        $command = "user:password:change";
        $input = new ArgvInput([
            'dummy-placeholder',
            $command,
            'testuser',
            'New4password',
            "--env=test"
        ]);
        $this->result = $this->application->doRun($input, $this->output);
    }

    /**
     * @Then I should get an success message
     */
    public function iShouldGetAnSuccessMessage(): void
    {
        Assert::assertEquals(0, $this->result);
    }

    /**
     * @Then password should be changed
     */
    public function passwordShouldBeChanged(): void
    {
        /** @var DoctrineUser */
        $user = $this->userRepository->byUsername(new Username('testuser'));
        Assert::assertNotEquals('password', $user->getPassword());
    }
}
