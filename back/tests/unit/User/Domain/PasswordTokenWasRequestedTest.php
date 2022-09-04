<?php

namespace App\Tests\unit\User\Domain;

use App\User\Domain\PasswordTokenWasRequested;
use PHPUnit\Framework\TestCase;

class PasswordTokenWasRequestedTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnProperData(): void
    {
        $sut = new PasswordTokenWasRequested('f123bc43-9b6c-4934-9a19-c78e5998000f');
        $this->assertEquals('f123bc43-9b6c-4934-9a19-c78e5998000f', $sut->userId());
        $this->assertEquals(
            '{"userId":"f123bc43-9b6c-4934-9a19-c78e5998000f"}',
            $sut->__toString()
        );
    }
}
