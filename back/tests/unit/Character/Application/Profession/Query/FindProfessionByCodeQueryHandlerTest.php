<?php

namespace App\Tests\unit\Character\Application\Profession\Query;

use App\Character\Application\Profession\Query\FindProfessionByCodeQuery;
use App\Character\Application\Profession\Query\FindProfessionByCodeQueryHandler;
use App\Character\Domain\Profession\ProfessionNotFoundException;
use App\Character\Domain\Profession\ProfessionReadModel;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FindProfessionByCodeQueryHandlerTest extends TestCase
{
    private FindProfessionByCodeQueryHandler $sut;
    private ProfessionReadModel&MockObject $readModel;

    protected function setUp(): void
    {
        $this->readModel = $this->createMock(ProfessionReadModel::class);
        $this->sut = new FindProfessionByCodeQueryHandler($this->readModel);
    }

    /** @test */
    public function itShouldThrowExceptionWhenLanguageCodeWrong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ($this->sut)(new FindProfessionByCodeQuery('as', 'cleric'));
    }

    /** @test */
    public function itShouldThrowExceptionWhenProfessionCodeWrong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ($this->sut)(new FindProfessionByCodeQuery('en', 'asd'));
    }
    /** @test */
    public function itShouldThrowExceptionWhenProfessionNotFound(): void
    {
        $this->expectException(ProfessionNotFoundException::class);
        $this->readModel->method('ofCode')->willThrowException(new ProfessionNotFoundException());
        ($this->sut)(new FindProfessionByCodeQuery('en', 'cleric'));
    }
    /** @test */
    public function itShouldReturnProperValues(): void
    {
        $expectedValues = ['cleric' => 'asd'];
        $this->readModel->method('ofCode')->willReturn($expectedValues);
        $result = ($this->sut)(new FindProfessionByCodeQuery('en', 'cleric'));
        $this->assertEqualsCanonicalizing($expectedValues, $result);
    }
}
