<?php

declare(strict_types=1);

namespace Uginroot\PhpEnum;

use ReflectionClass;
use Uginroot\PhpEnum\Exception\IncorrectNameException;

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

    public static function initChoice(): void
    {
        if(self::$choiceCache === null){
            self::$choiceCache = new ChoiceCache();
        }

        self::$choiceCache->initChoice(static::class);
    }

    public static function createByValue($value):self
    {
        return new static($value);
    }

    public static function createByName(string $name): self
    {
        $class = new ReflectionClass(static::class);
        $constant = $class->getReflectionConstant($name);

        if($constant === false || !$constant->isPublic()){
            throw new IncorrectNameException(
                sprintf(
                    'Incorrect constant %s in class %s',
                    $name,
                    static::class
                )
            );
        }

        /** @var static $self */
        $self = $class->newInstanceWithoutConstructor();
        $self->name = $name;
        $self->value = $constant->getValue();

        return $self;
    }

    public static function equal(?self $a, ?self $b):bool
    {
        if($a === $b){
            return true;
        }

        if($a === null || $b === null){
            return false;
        }

        if(get_class($a) !== get_class($b)){
            return false;
        }

        if($a->getValue() !== $b->getValue()){
            return false;
        }

        return true;
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