<?php
declare(strict_types=1);

namespace Uginroot\PhpEnum;


interface EnumInterface
{
    public function getName():string;

    public function getValue():int;

    public function isEqual(self $enum):bool;
}