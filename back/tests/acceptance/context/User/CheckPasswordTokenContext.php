<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\UserRepository;
use App\User\Domain\Username;
use Behat\Behat\Context\Context;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class CheckPasswordTokenContext implements Context
{
    private UserRepository $userRepository;
    private ?Response $response = null;
    private string $token = '';

    public function __construct(private KernelInterface $kernel)
    {
        $this->userRepository = $kernel->getContainer()->get('test.userRepository');
    }
    /**
     * @Given A non-auth user with a non existant token
     */
    public function aNonAuthUserWithANonExistantToken()
    {
        $this->token = 'a-non-existant-token';
    }

    /**
     * @When I check the token validity
     */
    public function iCheckTheTokenValidity()
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
    public function iShouldGetTheResponseFromTokenNotValid()
    {
        $this->checkStatusResponse(404);
    }

    /**
     * @Given A non-auth user with an expired token
     */
    public function aNonAuthUserWithAnExpiredToken()
    {
        $user = $this->userRepository->byUsername(new Username('expiredTokenUser'));
        $this->token = $user->passwordResetToken();
    }

    /**
     * @Then I should get the response from token expired
     */
    public function iShouldGetTheResponseFromTokenExpired()
    {
        $this->checkStatusResponse(400);
    }

    private function checkStatusResponse(int $statusCode): void
    {
        if ($this->response->getStatusCode() != $statusCode) {
            throw new RuntimeException(
                "Response must be $statusCode and received {$this->response->getStatusCode()}"
            );
        }
    }

    /**
     * @Given A non-auth user with a valid token
     */
    public function aNonAuthUserWithAValidToken()
    {
        $user = $this->userRepository->byUsername(new Username('validTokenUser'));
        $this->token = $user->passwordResetToken();
    }

    /**
     * @Then I should get OK response
     */
    public function iShouldGetOkResponse()
    {
        $this->checkStatusResponse(200);
    }
}
