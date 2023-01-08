<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\UserRepository;
use App\User\Domain\Username;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Behat\Behat\Context\Context;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class ChangePasswordContext implements Context
{
    private UserRepository $userRepository;
    private ?Response $response = null;
    private string $token = '';
    private string $oldPassword = '';

    public function __construct(private KernelInterface $kernel)
    {
        /** @phpstan-ignore-next-line */
        $this->userRepository = $kernel->getContainer()->get('test.userRepository');
    }
    /**
     * @Given A non-auth user with a non existant token
     */
    public function aNonAuthUserWithANonExistantToken(): void
    {
        $this->token = 'a-non-existant-token';
    }

    /**
     * @When I check the token validity
     */
    public function iCheckTheTokenValidity(): void
    {
        $request = Request::create(
            '/api/user/check-password-token/' . $this->token,
            'GET',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
        );
        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Then I should get the response from token not valid
     */
    public function iShouldGetTheResponseFromTokenNotValid(): void
    {
        $this->checkStatusResponse(404);
    }

    /**
     * @Given A non-auth user with an expired token
     */
    public function aNonAuthUserWithAnExpiredToken(): void
    {
        $user = $this->userRepository->byUsername(new Username('expiredTokenUser'));
        $this->token = $user->passwordResetToken();
    }

    /**
     * @Then I should get the response from token expired
     */
    public function iShouldGetTheResponseFromTokenExpired(): void
    {
        $this->checkStatusResponse(400);
    }

    private function checkStatusResponse(int $statusCode): void
    {
        if ($this->response?->getStatusCode() != $statusCode) {
            throw new RuntimeException(
                "Response must be $statusCode and received {$this->response?->getStatusCode()}"
            );
        }
    }

    /**
     * @Given A non-auth user with a valid token
     */
    public function aNonAuthUserWithAValidToken(): void
    {
        /** @var DoctrineUser */
        $user = $this->userRepository->byUsername(new Username('validTokenUser'));
        $this->token = $user->passwordResetToken();
        $this->oldPassword = $user->getPassword();
    }

    /**
     * @Then I should get OK response
     */
    public function iShouldGetOkResponse(): void
    {
        $this->checkStatusResponse(200);
    }

    /**
     * @Given A non-auth user with a valid checked token
     */
    public function aNonAuthUserWithAValidCheckedToken(): void
    {
        $this->aNonAuthUserWithAValidToken();
        $this->iCheckTheTokenValidity();
        $this->iShouldGetOkResponse();
    }

    /**
     * @When I request the password change
     */
    public function iRequestThePasswordChange(): void
    {
        $requestData = ['token' => $this->token, 'password' => 'n3wSecurePassword'];
        $parsedData = json_encode($requestData);
        $request = Request::create(
            '/api/user/password/change',
            'PATCH',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            $parsedData ? $parsedData : null
        );
        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Then The user should have password updated
     */
    public function theUserShouldHavePasswordUpdated(): void
    {
        $this->iShouldGetOkResponse();
        /** @var DoctrineUser */
        $user = $this->userRepository->byUsername(new Username('validTokenUser'));
        if ($user->getPassword() == $this->oldPassword) {
            throw new RuntimeException('Old password and new password are the same');
        }
    }
}
