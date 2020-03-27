# Php enum type

## Install
```bash
composer require uginroot/php-enum:^2.3
```

## Using
```php
use Uginroot\PhpEnum\Choice;
use Uginroot\PhpEnum\EnumAbstract;

class Month extends EnumAbstract {
    public const January = 1;
    public const February = 2;
}

$jun = new Month(Month::January);
$junName = Month::createByName('January');
$junValue = Month::createByValue(Month::January);

$jun->getValue(); // 1
$jun->getName();  // 'January'
$name = (string)$jun; // 'January'

$jun->is($junName);            // true
$jun->is($junValue);           // true
$jun->isName('January');       // true
$jun->isValue(Month::January); // true

// Immutable
$jun->setValue(Month::February); // new Month(Month::February)
$jun->setName('February'); // Month::createByName('February')

// Name and value variants
/** @var Choice $choice */
$choice = Month::getChoice();
$choice->getValues(); // [1, 2]
$choice->getNames();  // ['January', 'February']
$choice->getValue('January'); // 1
$choice->getName(Month::January); // 'January'
$choice->isValidName('January'); // true
$choice->isValidValue(Month::January); // true
```