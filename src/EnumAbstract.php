<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum;

use ReflectionException;

abstract class EnumAbstract
{
    /** @var ChoiceCache|null */
    private static $choiceCache;

    /** @var string */
    private $name;

    /** @var mixed */
    private $value;

    /**
     * @return Choice
     * @throws ReflectionException
     */
    public static function getChoice():Choice
    {
        if(self::$choiceCache === null){
            self::$choiceCache = new ChoiceCache();
        }

        return self::$choiceCache->getChoice(static::class);
    }

    /**
     * @param mixed $value
     * @return static
     * @throws ReflectionException
     */
    public static function createByValue($value):self
    {
        return new static($value);
    }

    /**
     * @param string $name
     * @return static
     * @throws ReflectionException
     */
    public static function createByName(string $name): self
    {
        return new static(static::getChoice()->getValue($name));
    }

    /**
     * EnumAbstract constructor.
     * @param $value
     * @throws ReflectionException
     */
    public function __construct($value)
    {
        $this->name = static::getChoice()->getName($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param self $value
     * @return bool
     */
    public function is(self $value): bool
    {
        return $value instanceof static && $value->getValue() === $this->getValue();
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isValue($value): bool
    {
        return $value === $this->getValue();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isName(string $name): bool
    {
        return $name === $this->getName();
    }

    /**
     * @param mixed$value
     * @return $this
     * @throws ReflectionException
     */
    public function setValue($value):self
    {
        return new static($value);
    }

    /**
     * @param string $name
     * @return $this
     * @throws ReflectionException
     */
    public function setName(string $name):self
    {
        return static::createByName($name);
    }
}