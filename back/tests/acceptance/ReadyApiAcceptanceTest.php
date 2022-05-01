<?php

namespace App\Tests\acceptance;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReadyApiAcceptanceTest extends WebTestCase
{
    private KernelBrowser $client;

    /** @test */
    public function asUserIWantCheckIfApiIsUpAndReady(): void
    {
        $this->givenASingleUser();
        $this->whenIRequestReadyEnpoint();
        $this->thenItShouldReturnProperResponse();
    }
    private function givenASingleUser(): void
    {
        $this->client = self::createClient();
    }
    private function whenIRequestReadyEnpoint(): void
    {
        $this->client->request(
            'GET',
            'api/ready',
            [],
            [],
            ['CONTENT-TYPE' => 'json/application']
        );
    }
    private function thenItShouldReturnProperResponse(): void
    {
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals(['ready' => true], $response);
    }
}
