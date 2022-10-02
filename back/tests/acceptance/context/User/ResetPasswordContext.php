<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class ResetPasswordContext implements Context
{
    private UserRepository $userRepository;
    private ?Response $response = null;
    private array $requestData = [];

    public function __construct(private KernelInterface $kernel)
    {
        $this->userRepository = $kernel->getContainer()->get('test.userRepository');
    }
    /**
     * @Given A non existant user
     */
    public function aNonExistantUser()
    {
        try {
            $this->userRepository->byUsername(new Username('agapito'));
            throw new RuntimeException('User agapito exists');
        } catch (UserNotFoundException) {
            $this->requestData = ['username' => 'notexistantuser'];
        }
    }

    /**
     * @When I want to reset my password
     */
    public function iWantToResetMyPassword()
    {
        $this->makeRequest($this->requestData);
    }

    /**
     * @Then I should receive a :statusCode response
     */
    public function iShouldReceiveAResponse(int $statusCode)
    {
        if ($this->response->getStatusCode() != $statusCode) {
            throw new RuntimeException(
                'Response must be ' . $statusCode .
                ' and received ' . $this->response->getStatusCode()
            );
        }
    }

    /**
     * @When I want to reset my password with no data
     */
    public function iWantToResetMyPasswordWithNoData()
    {
        $this->makeRequest([]);
    }

    /**
     * @Given A existing user
     */
    public function aExistingUser()
    {
        $user = $this->userRepository->byUsername(new Username('existinguser'));
        if (!empty($user->passwordResetToken())) {
            throw new RuntimeException('Password reset token must be empty!!!!');
        }
        $this->requestData = ['username' => 'existinguser'];
    }

    /**
     * @Then The user should have reset password token
     */
    public function theUserShouldHaveResetPasswordToken()
    {
        $user = $this->userRepository->byUsername(new Username('existinguser'));
        if (empty($user->passwordResetToken())) {
            throw new RuntimeException('Password token not found!!!!');
        }
    }

    private function makeRequest(array $requestData): void
    {
        $request = Request::create(
            '/api/user/reset-password',
            'PUT',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode($requestData)
        );
        $this->response = $this->kernel->handle($request);
    }
}
