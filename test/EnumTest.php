<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum\Test;

use PHPUnit\Framework\TestCase;
use Uginroot\PhpEnum\EnumAbstract;
use Uginroot\PhpEnum\Exception\IncorrectValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;

class EnumOne extends EnumAbstract{
    const one = 1;
}

class EnumTwo extends EnumAbstract{
    const one = 1;
    const two = 2;
}

class EnumBadDuplicate extends EnumAbstract{
    const one = 1;
    const two = 1;
}

class EnumTest extends TestCase
{
    public function testIncorrectValue()
    {
        $this->expectException(IncorrectValueException::class);
        EnumOne::createByValue(2);
    }

    public function testIncorrectName()
    {
        $this->expectException(IncorrectNameException::class);
        EnumOne::createByName('two');
    }

    public function testRedeclareValue()
    {
        $this->expectException(DuplicateValueException::class);
        EnumBadDuplicate::getNames();
    }

    public function testCreateByValue()
    {
        $enum = EnumOne::createByValue(EnumOne::one);

        $this->assertSame(1, $enum->getValue());
        $this->assertSame('one', $enum->getName());
    }

    public function testCreateByName()
    {
        $enum = EnumOne::createByName('one');

        $this->assertSame(1, $enum->getValue());
        $this->assertSame('one', $enum->getName());
    }

    public function testNames()
    {
        $expected = ['one', 'two'];
        $this->assertSame($expected, EnumTwo::getNames());
    }

    public function testValues()
    {
        $expected = [1, 2];
        $this->assertSame($expected, EnumTwo::getValues());
    }

    public function testToString()
    {
        $this->assertSame('one', (string)EnumOne::createByValue(EnumOne::one));
    }

    public function testIsEqual()
    {
        $oneByValue = EnumOne::createByValue(EnumTwo::one);
        $oneByName = EnumOne::createByName('one');
        $oneByTwo = EnumTwo::createByValue(EnumOne::one);


        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue($oneByValue == $oneByName);
        $this->assertTrue($oneByValue === $oneByName);
        $this->assertTrue($oneByValue->isEqual($oneByName));

        $this->assertFalse($oneByValue->isEqual($oneByTwo));
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertFalse($oneByValue == $oneByTwo);
        $this->assertFalse($oneByValue === $oneByTwo);
    }
}