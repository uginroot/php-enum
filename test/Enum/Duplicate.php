<?php /** @noinspection PhpUnused */


namespace Uginroot\PhpEnum\Test\Enum;


use Uginroot\PhpEnum\EnumAbstract;

class Duplicate extends EnumAbstract{
    public const one = 1;
    public const two = 1;
}