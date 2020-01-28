<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum;

use ReflectionClass;
use Uginroot\PhpEnum\Exception\IncorrectValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;

abstract class EnumAbstract implements EnumInterface
{
    /** @var array[] */
    protected static $namesCache = [];

    /** @var array[] */
    protected static $valuesCache = [];

    /** @var array[] */
    protected static $instancesCache = [];

    /** @var string */
    protected $name;

    /** @var int */
    protected $value;

    private final function __construct(int $value)
    {
        $this->value = $value;
        $this->name  = static::getNames()[$value];
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isEqual(EnumInterface $enum): bool
    {
        return $this === $enum;
    }

    /**
     * @return string[]
     */
    public static function getNames(): array
    {
        static::init();
        return static::$namesCache[static::class];
    }

    /**
     * @return integer[]
     */
    public static function getValues(): array
    {
        static::init();
        return static::$valuesCache[static::class];
    }

    /**
     * @return static[]
     */
    public static function getInstances():array
    {
        static::init();
        return static::$instancesCache[static::class];
    }

    protected static function declareValue(string $name, int $value): void
    {
        if (in_array($value, static::$valuesCache[static::class])) {
            throw new DuplicateValueException("Duplicate value '{$value}'");
        }

        static::$namesCache[static::class][$value] = $name;
        static::$valuesCache[static::class][$name] = $value;
        static::$instancesCache[static::class][$value]  = new static($value);
    }

    protected static function init():void
    {
        if (array_key_exists(static::class, static::$instancesCache)) {
            return;
        }

        static::$namesCache[static::class]  = [];
        static::$valuesCache[static::class] = [];
        static::$instancesCache[static::class]   = [];

        $class = new ReflectionClass(static::class);

        foreach ($class->getReflectionConstants() as $constant) {
            static::declareValue(
                $constant->getName(),
                $constant->getValue()
            );
        }
    }

    /**
     * @param int $value
     * @return static
     */
    public static function createByValue(int $value)
    {
        if (!in_array($value, static::getValues(), true)) {
            throw new IncorrectValueException("Incorrect value '{$value}'");
        }
        return static::getInstances()[$value];
    }

    /**
     * @param string $name
     * @return static
     */
    public static function createByName(string $name)
    {
        if (!array_key_exists($name, static::getValues())) {
            throw new IncorrectNameException("Incorrect name '{$name}'");
        }

        return static::getInstances()[static::getValues()[$name]];
    }

    private final function __clone(){}

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private final function __wakeup(){}

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private final function __sleep(){}
}