<?php
declare(strict_types=1);

namespace Uginroot\PhpEnum;


interface EnumInterface
{
    public function getName():string;

    /**
     * @return mixed
     */
    public function getValue();

    public function isEqual(self $enum):bool;
}