<?php

namespace App\Tests\unit\Character\Infrastructure\Persistence\File;

use App\Character\Domain\Profession\ProfessionLanguage;
use App\Character\Domain\Profession\ProfessionNamesReadException;
use App\Character\Domain\Profession\ProfessionNamesReadModel;
use App\Character\Infrastructure\Persistence\File\FileProfessionNamesReadModel;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FileProfessionNamesReadModelTest extends TestCase
{
    /** @test */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new FileProfessionNamesReadModel(__DIR__ . '/example.json');
        $this->assertInstanceOf(FileProfessionNamesReadModel::class, $sut);
        $this->assertInstanceOf(ProfessionNamesReadModel::class, $sut);
    }

    /** @test */
    public function itShouldThrowErrorIfDataFileDoesNotExists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FileProfessionNamesReadModel('asd');
    }

    /** @test */
    public function itShouldThrowErrorIfFileCannotBeParsed(): void
    {
        $this->expectException(ProfessionNamesReadException::class);
        $sut = new FileProfessionNamesReadModel(__DIR__ . '/bad-json.json');
        $sut->ofLanguage(ProfessionLanguage::fromString('es'));
    }

    /**
     * @test
     * */
    public function itShouldReturnProperValues(): void
    {
        $expectedResult = [
            ["code" => "rogue", "name" =>  "Bribón"],
            ["code" => "cleric", "name" =>  "Clérigo"],
            ["code" => "ranger", "name" =>  "Explorador"],
            ["code" => "harper", "name" =>  "Harpista"],
            ["code" => "thief", "name" =>  "Ladrón"],
            ["code" => "fighter", "name" =>  "Luchador"],
            ["code" => "mage", "name" =>  "Mago"],
            ["code" => "warriorMage", "name" =>  "Mago Guerrero"],
            ["code" => "monk", "name" =>  "Monje"]
        ];
        $sut = new FileProfessionNamesReadModel(__DIR__ . '/example.json');
        $result = $sut->ofLanguage(ProfessionLanguage::fromString('es'));
        foreach ($expectedResult as $key => $item) {
            $itemResult = $result[$key];
            $this->assertEqualsCanonicalizing($item, $itemResult);
        }
    }
}
