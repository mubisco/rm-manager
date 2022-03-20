<?php

namespace App\Ready\Infrastructure\EntryPoint\Api;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReadyControllerTest extends TestCase
{
    public function testShouldReturnJsonResponse(): void
    {
        $sut = new ReadyController();
        $result = $sut->index();
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('{"ready":true}', $result->getContent());
    }
}
