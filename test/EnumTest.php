<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum\Test;

use PHPUnit\Framework\TestCase;
use Uginroot\PhpEnum\Exception\IncorrectValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;
use Uginroot\PhpEnum\Test\Enum\Duplicate;
use Uginroot\PhpEnum\Test\Enum\One;
use Uginroot\PhpEnum\Test\Enum\Two;


class EnumTest extends TestCase
{
    public function testIncorrectValue():void
    {
        $this->expectException(IncorrectValueException::class);
        One::createByValue(2);
    }

    public function testIncorrectName():void
    {
        $this->expectException(IncorrectNameException::class);
        One::createByName('two');
    }

    public function testRedeclareValue():void
    {
        $this->expectException(DuplicateValueException::class);
        Duplicate::getChoice()->getNames();
    }

    public function testCreateByValue():void
    {
        $enum = One::createByValue(One::one);

        $this->assertSame(1, $enum->getValue());
        $this->assertSame('one', $enum->getName());
    }

    public function testCreateByName():void
    {
        $enum = One::createByName('one');

        $this->assertSame(1, $enum->getValue());
        $this->assertSame('one', $enum->getName());
    }

    public function testChoicesName():void
    {
        $expected = ['one', 'two'];
        $this->assertSame($expected, Two::getChoice()->getNames());
    }

    public function testChoicesValue():void
    {
        $expected = [1, 2];
        $this->assertSame($expected, Two::getChoice()->getValues());
    }

    public function testChoiceName():void
    {
        $this->assertSame('one', One::getChoice()->getName(One::one));
    }

    public function testChoiceValue():void
    {
        $this->assertSame(One::one, One::getChoice()->getValue('one'));
    }

    public function testToString():void
    {
        $one = new One(One::one);
        $this->assertSame('one', $one->__toString());
    }

    public function testGetName():void
    {
        $one = new One(One::one);
        $this->assertSame('one', $one->getName());
    }

    public function testGetValue():void
    {
        $one = new One(One::one);
        $this->assertSame(One::one, $one->getValue());
    }

    public function testIsEqual():void
    {
        $one = new One(One::one);
        $oneDuplicate = new One(One::one);
        $two = new Two(Two::two);

        $this->assertTrue($one->is($oneDuplicate));
        $this->assertTrue($one->isName('one'));
        $this->assertTrue($one->isValue(One::one));

        $this->assertFalse($one->is($two));
        $this->assertFalse($one->isName('twp'));
        $this->assertFalse($one->isValue(Two::two));
    }

    public function testIsValidName():void
    {
        $this->assertTrue(One::getChoice()->isValidName('one'));
        $this->assertFalse(One::getChoice()->isValidName('two'));
    }

    public function testIsValidValue():void
    {
        $this->assertTrue(One::getChoice()->isValidValue(One::one));
        $this->assertFalse(One::getChoice()->isValidValue(Two::two));
    }

    public function testSetName():void
    {
        $two = new Two(Two::one);
        $two = $two->setName('two');

        $this->assertSame(Two::two, $two->getValue());
    }

    public function testSetValue():void
    {
        $two = new Two(Two::one);
        $two = $two->setValue(Two::two);

        $this->assertSame(Two::two, $two->getValue());
    }
}