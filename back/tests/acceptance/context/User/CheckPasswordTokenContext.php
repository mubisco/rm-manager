<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\UserNotFoundException;
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

    public function __construct(private KernelInterface $kernel)
    {
        $this->userRepository = $kernel->getContainer()->get('test.userRepository');
    }
    /**
     * @Given A non-auth user with a non existant token
     */
    public function aNonAuthUserWithANonExistantToken()
    {
        try {
            $this->userRepository->byUsername(new Username('agapito'));
            throw new RuntimeException('User agapito exists');
        } catch (UserNotFoundException) {
        }
    }

    /**
     * @When I check the token validity
     */
    public function iCheckTheTokenValidity()
    {
        $request = Request::create(
            '/api/account/check-token/a-non-existant-token',
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
        if ($this->response->getStatusCode() != 404) {
            throw new RuntimeException(
                'Response must be 404' .
                ' and received ' . $this->response->getStatusCode()
            );
        }
    }
}
