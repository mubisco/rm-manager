<?php

namespace App\Tests\unit\User\Infrastructure\EntryPoint\Console;

use App\User\Application\Command\CreateUserCommand;
use App\User\Infrastructure\EntryPoint\Console\CreateUserConsoleCommand;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateUserConsoleCommandTest extends TestCase
{
    private CreateUserConsoleCommand $sut;
    private InputInterface&MockObject $inputInterface;
    private OutputInterface&MockObject $outputInterface;
    private MessageBusInterface&MockObject $bus;

    protected function setUp(): void
    {
        $this->inputInterface = $this->createMock(InputInterface::class);
        $this->outputInterface = $this->createMock(OutputInterface::class);
        $this->bus = $this->createMock(MessageBusInterface::class);
        $this->sut = new CreateUserConsoleCommand($this->bus);
    }
    /**
     * @test
     */
    public function itShouldThrowExceptionIfMandatoryParamsNotPresent(): void
    {
        $this->bus->method('dispatch')->willThrowException(new InvalidArgumentException());
        $result = $this->sut->execute($this->inputInterface, $this->outputInterface);
        $this->assertEquals(Command::FAILURE, $result);
    }

    /**
     * @test
     */
    public function itShouldReturnProperResultIfParamsPresent(): void
    {
        $this->bus->method('dispatch')
                  ->with($this->isInstanceOf(CreateUserCommand::class))
                  ->willReturn(new Envelope($this));
        $result = $this->sut->execute($this->inputInterface, $this->outputInterface);
        $this->assertEquals(Command::SUCCESS, $result);
    }
}
