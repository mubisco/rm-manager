<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use Behat\Behat\Context\Context;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class ResetPasswordContext implements Context
{
    private UserRepository $userRepository;
    private ?Response $response = null;
    /** @var array<string, string> */
    private array $requestData = [];

    public function __construct(private KernelInterface $kernel)
    {
        /** @phpstan-ignore-next-line */
        $this->userRepository = $kernel->getContainer()->get('test.userRepository');
    }
    /**
     * @Given A non existant user
     */
    public function aNonExistantUser(): void
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
    public function iWantToResetMyPassword(): void
    {
        $this->makeRequest($this->requestData);
    }

    /**
     * @Then I should receive a :expectedStatusCode response
     */
    public function iShouldReceiveAResponse(int $expectedStatusCode): void
    {
        $statusCode = $this->response?->getStatusCode();
        if ($statusCode != $expectedStatusCode) {
            throw new RuntimeException(
                'Response must be ' . $expectedStatusCode .
                ' and received ' . $statusCode
            );
        }
    }

    /**
     * @When I want to reset my password with no data
     */
    public function iWantToResetMyPasswordWithNoData(): void
    {
        $this->makeRequest([]);
    }

    /**
     * @Given A existing user
     */
    public function aExistingUser(): void
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
    public function theUserShouldHaveResetPasswordToken(): void
    {
        $user = $this->userRepository->byUsername(new Username('existinguser'));
        if (empty($user->passwordResetToken())) {
            throw new RuntimeException('Password token not found!!!!');
        }
    }

    /** @param array<string, string> $requestData */
    private function makeRequest(array $requestData): void
    {
        $parsedResponse = json_encode($requestData);
        $request = Request::create(
            '/api/user/reset-password',
            'PUT',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            $parsedResponse ? $parsedResponse : ''
        );
        $this->response = $this->kernel->handle($request);
    }
}
