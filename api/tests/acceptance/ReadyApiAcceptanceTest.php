<?php

namespace App\Tests\acceptance;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReadyApiAcceptanceTest extends WebTestCase
{
    /** @test */
    public function asClientIWantToQueueSimpleMail(): void
    {
        $client = self::createClient();
        $client->request(
            'GET',
            'api/ready',
            [],
            [],
            ['CONTENT-TYPE' => 'json/application']
        );
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals(['ready' => true], $response);
    }
}
