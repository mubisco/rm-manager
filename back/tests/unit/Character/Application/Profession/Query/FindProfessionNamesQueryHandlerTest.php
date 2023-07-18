<?php

namespace App\Tests\unit\Character\Application\Profession\Query;

use App\Character\Application\Profession\Query\FindProfessionNamesQuery;
use App\Character\Application\Profession\Query\FindProfessionNamesQueryHandler;
use App\Character\Domain\Profession\ProfessionNamesReadException;
use App\Character\Domain\Profession\ProfessionNamesReadModel;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FindProfessionNamesQueryHandlerTest extends TestCase
{
    private FindProfessionNamesQueryHandler $sut;
    private ProfessionNamesReadModel&MockObject $readModel;

    protected function setUp(): void
    {
        $this->readModel = $this->createMock(ProfessionNamesReadModel::class);
        $this->sut = new FindProfessionNamesQueryHandler($this->readModel);
    }

    /** @test */
    public function itShouldThrowExceptionWhenWrongLanguage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ($this->sut)(new FindProfessionNamesQuery('sd'));
    }

    /** @test */
    public function itShouldThrowExceptionWhenReadModelFails(): void
    {
        $this->expectException(ProfessionNamesReadException::class);
        $this->readModel->method('ofLanguage')->willThrowException(new ProfessionNamesReadException());
        ($this->sut)(new FindProfessionNamesQuery('es'));
    }

    /**
     * @test
     * it_should_return_proper_values
     */
    public function itShouldReturnProperValues(): void
    {
        $expectedValues = [['name' => 'Clérigo', 'code' => 'cleric']];
        $this->readModel->method('ofLanguage')->willReturn($expectedValues);
        $result = ($this->sut)(new FindProfessionNamesQuery('es'));
        $this->assertEquals($expectedValues, $result);
    }
}
