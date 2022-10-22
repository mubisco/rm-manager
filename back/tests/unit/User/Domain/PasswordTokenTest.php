<?php

namespace App\Tests\unit\User\Domain;

use App\User\Domain\PasswordToken;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordTokenTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedFromEmpty(): void
    {
        $sut = PasswordToken::fromEmpty();
        $this->assertInstanceOf(PasswordToken::class, $sut);
    }

    /**
     * @test
     */
    public function itShouldCreateManyTokensWithoutRepeat(): void
    {
        $iterations = 10;
        $tokens = [];
        for ($i = 0; $i < $iterations; $i++) {
            $sut = PasswordToken::fromEmpty();
            $token = $sut->value();
            $this->assertFalse(in_array($token, $tokens), 'Failed on ' . $i + 1 . ' iteration');
            $tokens[] = $token;
        }
    }

    /**
     * @test
     */
    public function itShouldReturnProperTokenValue(): void
    {
        $exampleToken = '99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507';
        $sut = PasswordToken::fromString($exampleToken);
        $this->assertEquals($exampleToken, $sut->value());
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenTokenLengthNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $exampleToken = '99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade88718350';
        PasswordToken::fromString($exampleToken);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenTokenCharsNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $exampleToken = '99c54fEf52e9b2db8085d0f588;f8c96f8eb0f3f473456e939eaade887183507';
        PasswordToken::fromString($exampleToken);
    }
}
