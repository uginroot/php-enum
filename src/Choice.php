<?php


namespace Uginroot\PhpEnum;


use ReflectionClass;
use Uginroot\PhpEnum\Exception\DuplicateValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\IncorrectValueException;

class Choice
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var array|string[]
     */
    private $names = [];

    private $values = [];

    public function __construct(string $class)
    {
        $this->class = $class;
        $reflectionClass = new ReflectionClass($class);

        foreach ($reflectionClass->getReflectionConstants() as $constant){
            if(!$constant->isPublic()){
                continue;
            }

            $this->names[] = $constant->getName();
            $this->values[] = $constant->getValue();
        }

        if(count(array_unique($this->values)) !== count($this->values)){
            throw new DuplicateValueException("Detect duplicate public constant values in class {$class}");
        }
    }

    /**
     * @return array|string[]
     */
    public function getNames():array
    {
        return $this->names;
    }

    public function getValues():array
    {
        return $this->values;
    }

    public function getName($value):string
    {
        $index = array_search($value, $this->values, true);

        if($index === false){
            throw new IncorrectValueException("Incorrect public constant value '{$value}' in class {$this->class}");
        }

        return $this->names[$index];
    }

    public function getValue(string $name)
    {
        $index = array_search($name, $this->names, true);

        if($index === false){
            throw new IncorrectNameException("Incorrect constant '{$name}' in class {$this->class}");
        }

        return $this->values[$index];
    }

    public function isValidName(string $name):bool
    {
        return in_array($name, $this->names, true);
    }

    public function isValidValue($value):bool
    {
        return in_array($value, $this->values, true);
    }
}