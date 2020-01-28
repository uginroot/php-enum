<?php
declare(strict_types=1);

namespace Uginroot\PhpEnum;


interface EnumInterface
{
    public function __toString();

    public function getName():string;

    public function getValue():int;

    public function isEqual(self $enum):bool;

    /**
     * @return string[]
     */
    public static function getNames():array;

    /**
     * @return int[]
     */
    public static function getValues():array;

    /**
     * @param int $value
     * @return static
     */
    public static function createByValue(int $value);

    /**
     * @param string $name
     * @return static
     */
    public static function createByName(string $name);
}