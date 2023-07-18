<?php

namespace App\Tests\unit\Character\Domain\Profession;

use App\Character\Domain\Profession\ProfessionLanguage;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProfessionLanguageTest extends TestCase
{
    /** @test */
    public function itShouldThrowExceptionWhenValueNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProfessionLanguage::fromString('sd');
    }

    /** @test */
    public function itShouldReturnProperValue(): void
    {
        $sut = ProfessionLanguage::fromString('en');
        $this->assertEquals('en', $sut->value());
    }

    /** @test */
    public function itShouldReturnProperValueFromDifferentInstance(): void
    {
        $sut = ProfessionLanguage::fromString('es');
        $this->assertEquals('es', $sut->value());
    }
}
