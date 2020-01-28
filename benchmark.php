<?php
declare(strict_types=1);

use Uginroot\PhpEnum\EnumAbstract;

require_once 'vendor/autoload.php';

class Enum extends EnumAbstract
{
    const
        zero = 0,
        one = 1,
        two = 2,
        three = 3,
        four = 4,
        five = 5,
        six = 6,
        seven = 7,
        eight = 8,
        nine = 9
    ;
}

$values = Enum::getValues();
$iterations = $argv[1] ?? 1000000;
$start = microtime(true);

for($index = 0; $index < $iterations; $index++){
    Enum::createByValue($values[array_rand($values)]);
}

$end = microtime(true);
$diff = $end - $start;
echo "Execution time {$diff}";