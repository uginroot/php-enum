<?php


namespace Uginroot\PhpEnum;


use ReflectionException;

class EnumConstantsCache
{
    /**
     * @var array|EnumConstants[]
     */
    private array $cache = [];

    /**
     * @param string $class
     * @throws ReflectionException
     */
    private function init(string $class):void
    {
        if(!array_key_exists($class, $this->cache)){
            $this->cache[$class] = new EnumConstants($class);
        }
    }

    /**
     * @param string $class
     * @return array
     * @throws ReflectionException
     */
    public function getValues(string $class):array
    {
        $this->init($class);
        return $this->cache[$class]->getValues();
    }

    /**
     * @param string $class
     * @param string $name
     * @return mixed
     * @throws ReflectionException
     */
    public function getValue(string $class, string $name)
    {
        $this->init($class);
        return $this->cache[$class]->getValue($name);
    }

    /**
     * @param string $class
     * @return array
     * @throws ReflectionException
     */
    public function getNames(string $class):array
    {
        $this->init($class);
        return $this->cache[$class]->getNames();
    }

    /**
     * @param string $class
     * @param $value
     * @return string
     * @throws ReflectionException
     */
    public function getName(string $class, $value):string
    {
        $this->init($class);
        return $this->cache[$class]->getName($value);
    }
}