<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum;

use ReflectionClass;
use Uginroot\PhpEnum\Exception\IncorrectValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;

abstract class EnumAbstract implements EnumInterface
{
    protected static array $instancesCache = [];

    protected string $name;

    /** @var mixed */
    protected $value;


    private final function __construct(){}

    public function __toString()
    {
        return $this->name;
    }

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

    public function isEqual(EnumInterface $enum): bool
    {
        return $this === $enum;
    }

    /**
     * @return array|string[]
     */
    public static function getNames()
    {
        return array_map(fn(self $enum) => $enum->getName(),static::getInstances());
    }

    /**
     * @return array|mixed[]
     */
    public static function getValues()
    {
        return array_map(fn(self $enum) => $enum->getValue(),static::getInstances());
    }

    /**
     * @return array|static[]
     */
    public static function getInstances():array
    {
        static::init();
        return static::$instancesCache[static::class];
    }

    protected static function init():void
    {
        if (array_key_exists(static::class, static::$instancesCache)) {
            return;
        }

        $values = [];
        $instances = [];

        $class = new ReflectionClass(static::class);

        foreach ($class->getReflectionConstants() as $constant) {
            $value = $constant->getValue();

            if(in_array($value, $values, true)){
                throw new DuplicateValueException("Duplicate value '$value' in class {$class->getName()}");
            }

            $name = $constant->getName();
            $instance = new static();
            $instance->value = $value;
            $instance->name = $name;

            $values[] = $value;
            $instances[] = $instance;
        }

        static::$instancesCache[static::class] = $instances;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public static function createByValue($value)
    {
        foreach (static::getInstances() as $enum){
            if($enum->getValue() === $value){
                return $enum;
            }
        }
        throw new IncorrectValueException("Incorrect value '{$value}'");
    }

    /**
     * @param string $name
     * @return static
     */
    public static function createByName(string $name)
    {
        foreach (static::getInstances() as $enum){
            if($enum->getName() === $name){
                return $enum;
            }
        }
        throw new IncorrectNameException("Incorrect name '{$name}'");
    }

    private final function __clone(){}

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private final function __wakeup(){}

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private final function __sleep(){}
}