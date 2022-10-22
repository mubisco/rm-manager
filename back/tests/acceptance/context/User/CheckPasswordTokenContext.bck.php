<?php

declare(strict_types=1);

namespace App\Tests\acceptance\context\User;

use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use App\User\Domain\Username;
use Behat\Behat\Tester\Exception\PendingException;
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
     * @Given A non-auth user with a token
     */
    public function aNonAuthUserWithAToken()
    {
        try {
            $this->userRepository->byUsername(new Username('agapito'));
            throw new RuntimeException('User agapito exists');
        } catch (UserNotFoundException) {
        }
    }

    /**
     * @When The token does not exists
     */
    public function theTokenDoesNotExists()
    {
        throw new PendingException();
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
}
