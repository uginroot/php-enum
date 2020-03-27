<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum;

abstract class EnumAbstract
{
    /** @var ChoiceCache|null */
    private static $choiceCache;

    /** @var string */
    private $name;

    /** @var mixed */
    private $value;

    public static function getChoice():Choice
    {
        if(self::$choiceCache === null){
            self::$choiceCache = new ChoiceCache();
        }

        return self::$choiceCache->getChoice(static::class);
    }


    public static function createByValue($value):self
    {
        return new static($value);
    }

    public static function createByName(string $name): self
    {
        return new static(static::getChoice()->getValue($name));
    }

    public function __construct($value)
    {
        $this->name = static::getChoice()->getName($value);
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function is(self $value): bool
    {
        return $value instanceof static && $value->getValue() === $this->getValue();
    }

    public function isValue($value): bool
    {
        return $value === $this->getValue();
    }

    public function isName(string $name): bool
    {
        return $name === $this->getName();
    }

    public function setValue($value):self
    {
        return new static($value);
    }

    public function setName(string $name):self
    {
        return static::createByName($name);
    }
}