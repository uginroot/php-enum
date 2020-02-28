<?php


namespace Uginroot\PhpEnum;


use ReflectionClass;
use ReflectionException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\IncorrectValueException;

class EnumConstants
{
    /**
     * @var string
     */
    private string $class;

    /**
     * @var array|string[]
     */
    private array $names = [];

    /**
     * @var array|mixed[]
     */
    private array $values = [];

    /**
     * EnumClassCache constructor.
     * @param string $class
     * @throws ReflectionException
     */
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

    /**
     * @return array|mixed[]
     */
    public function getValues():array
    {
        return $this->values;
    }

    /**
     * @param $value
     * @return string
     */
    public function getName($value):string
    {
        $index = array_search($value, $this->values, true);

        if($index === false){
            throw new IncorrectValueException("Incorrect public constant value '{$value}' in class {$this->class}");
        }

        return $this->names[$index];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getValue(string $name)
    {
        $index = array_search($name, $this->names, true);

        if($index === false){
            throw new IncorrectNameException("Incorrect constant '{$name}' in class {$this->class}");
        }

        return $this->values[$index];
    }
}