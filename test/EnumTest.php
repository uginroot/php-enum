<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum\Test;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Uginroot\PhpEnum\Exception\IncorrectValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;
use Uginroot\PhpEnum\Test\Enum\Duplicate;
use Uginroot\PhpEnum\Test\Enum\One;
use Uginroot\PhpEnum\Test\Enum\Two;


class EnumTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testIncorrectValue():void
    {
        $this->expectException(IncorrectValueException::class);
        One::createByValue(2);
    }

    /**
     * @throws ReflectionException
     */
    public function testIncorrectName():void
    {
        $this->expectException(IncorrectNameException::class);
        One::createByName('two');
    }

    /**
     * @throws ReflectionException
     */
    public function testRedeclareValue():void
    {
        $this->expectException(DuplicateValueException::class);
        Duplicate::getChoice()->getNames();
    }

    /**
     * @throws ReflectionException
     */
    public function testCreateByValue():void
    {
        $enum = One::createByValue(One::one);

        $this->assertSame(1, $enum->getValue());
        $this->assertSame('one', $enum->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testCreateByName():void
    {
        $enum = One::createByName('one');

        $this->assertSame(1, $enum->getValue());
        $this->assertSame('one', $enum->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testChoicesName():void
    {
        $expected = ['one', 'two'];
        $this->assertSame($expected, Two::getChoice()->getNames());
    }

    /**
     * @throws ReflectionException
     */
    public function testChoicesValue():void
    {
        $expected = [1, 2];
        $this->assertSame($expected, Two::getChoice()->getValues());
    }

    /**
     * @throws ReflectionException
     */
    public function testChoiceName():void
    {
        $this->assertSame('one', One::getChoice()->getName(One::one));
    }

    /**
     * @throws ReflectionException
     */
    public function testChoiceValue():void
    {
        $this->assertSame(One::one, One::getChoice()->getValue('one'));
    }

    /**
     * @throws ReflectionException
     */
    public function testToString():void
    {
        $this->assertSame('one', (string)One::createByValue(One::one));
    }

    /**
     * @throws ReflectionException
     */
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
}