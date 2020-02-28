<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum;

use ReflectionException;

abstract class EnumAbstract
{
    /** @var EnumConstantsCache|null */
    private static ?EnumConstantsCache $cache = null;

    /** @var string */
    private string $name;

    /** @var mixed */
    private $value;

    /**
     * EnumAbstract constructor.
     * @param $value
     * @throws ReflectionException
     */
    public function __construct($value)
    {
        $this->name = self::getCache()->getName(static::class, $value);
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
     * @return array|string[]
     * @throws ReflectionException
     */
    public static function getNames():array
    {
        return self::getCache()->getNames(static::class);
    }

    /**
     * @return array|mixed[]
     * @throws ReflectionException
     */
    public static function getValues():array
    {
        return self::getCache()->getValues(static::class);
    }

    /**
     * @return EnumConstantsCache
     */
    public static function getCache():EnumConstantsCache
    {
        if(self::$cache === null){
            self::$cache = new EnumConstantsCache();
        }

        return self::$cache;
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
        return new static(self::getCache()->getValue(static::class, $name));
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