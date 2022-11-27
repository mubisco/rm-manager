<?php

namespace App\Ready\Infrastructure\EntryPoint\Api;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReadyControllerTest extends TestCase
{
    private ReadyController $sut;

    protected function setUp(): void
    {
        $this->sut = new ReadyController();
    }

    public function testShouldReturnJsonResponse(): void
    {
        $result = $this->sut->index();
        $this->checkProperRespose($result, '{"ready":true}');
    }

    /**
     * @test
     */
    public function itShouldReturnJsonResponseWhenCallingAdmin(): void
    {
        $result = $this->sut->admin();
        $this->checkProperRespose($result, '{"admin":true}');
    }

    /**
     * @test
     */
    public function itShouldReturnJsonResponseWhenCallingMaster(): void
    {
        $result = $this->sut->master();
        $this->checkProperRespose($result, '{"master":true}');
    }

    /**
     * @test
     */
    public function itShouldReturnProperJsonResponseWhenCallingPlayer(): void
    {
        $result = $this->sut->player();
        $this->checkProperRespose($result, '{"player":true}');
    }

    private function checkProperRespose(mixed $result, string $expectedResponse): void
    {
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals($expectedResponse, $result->getContent());
    }
}
