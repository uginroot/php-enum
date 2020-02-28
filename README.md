# Install
```bash
composer require uginroot/php-enum:^2.0
```
# Using
```php
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
(string)$jun;     // 'January'

$jun->is($junName);            // true
$jun->is($junValue);           // true
$jun->isName('January');       // true
$jun->isValue(Month::January); // true

// Immutable
$jun->setValue(Month::February); // new Month(Month::February)
$jun->setName('February'); // Month::createByName('February')

// Name and value variants
Month::getChoicesValue(); // [1, 2]
Month::getChoicesName();  // ['January', 'February']
Month::getChoiceValue('January'); // 1
Month::getChoiceValue(Month::January); // 'January'

```

#### Run tests
```bash
>composer test
```