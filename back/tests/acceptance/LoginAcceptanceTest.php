<?php

namespace App\Tests\acceptance;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginAcceptanceTest extends WebTestCase
{
    private KernelBrowser $client;

    /** @test */
    public function asNonAuthenticatedUserIWantToLogin(): void
    {
        $this->givenANonAuthenticatedUser();
        $this->whenITryToLogInWith('mubisco', 'patatas');
        $this->thenItShouldReturnProperResponse();
    }
    private function givenANonAuthenticatedUser()
    {
        $this->client = self::createClient();
    }
    private function whenITryToLogInWith($email, $password)
    {
        $this->client->request(
            'POST',
            'api/login',
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode(['email' => $email, 'password' => $password], JSON_THROW_ON_ERROR)
        );
    }
    private function thenItShouldReturnProperResponse()
    {
        $this->assertResponseStatusCodeSame(200);
    }
}
