<?php


namespace Uginroot\PhpEnum;


use ReflectionException;

class ChoiceCache
{
    /**
     * @var array|Choice[]
     */
    private array $choices = [];

    /**
     * @param string $class
     * @return mixed|Choice
     * @throws ReflectionException
     */
    public function getChoice(string $class)
    {
        if(!array_key_exists($class, $this->choices)){
            $this->choices[$class] = new Choice($class);
        }

        return $this->choices[$class];
    }
}