# Install
```bash
composer require uginroot/php-enum:^1.0
```
# Using
```php
use Uginroot\PhpEnum\EnumAbstract;

class Month extends EnumAbstract {
    const January = 1;
    const February = 2;
}

$monthByValue = Month::createByValue(Month::January);
$monthByName = Month::createByName('January');
$monthOther = Month::createByValue(Month::February);


$monthByValue->getValue(); // 1
$monthByValue->getName(); // 'January'

$monthByValue->isEqual($monthByName); // true
$monthByValue->isEqual($monthOther); // false

$monthByValue == $monthByName; // true
$monthByValue === $monthByName; // true

$monthByValue == $monthOther; // false
$monthByValue === $monthOther; // false

$string = (string)$monthByValue; // 'January'

Month::getValues(); // [1, 2]
Month::getNames();  // ['January', 'February']

```

# Exceptions
```php
use Uginroot\PhpEnum\EnumAbstract;
use Uginroot\PhpEnum\Exception\IncorrectValueException;
use Uginroot\PhpEnum\Exception\IncorrectNameException;
use Uginroot\PhpEnum\Exception\DuplicateValueException;

class Month extends EnumAbstract {
    const January = 1;
    const February = 2;
}
try{ Month::createByValue(0); } catch (IncorrectValueException $e){}
try{ Month::createByName('None'); } catch (IncorrectNameException $e){}

class BadEnumDuplicate extends EnumAbstract{
    const one = 1;
    const two = 1; // duplicate key
}

try{ BadEnumDuplicate::createByValue(1);    } catch (DuplicateValueException $e){}
try{ BadEnumDuplicate::createByName('one'); } catch (DuplicateValueException $e){}
try{ BadEnumDuplicate::getNames();          } catch (DuplicateValueException $e){}
try{ BadEnumDuplicate::getValues();         } catch (DuplicateValueException $e){}
try{ BadEnumDuplicate::getInstances();      } catch (DuplicateValueException $e){}

```

#### Run tests
```bash
>composer test
```

#### Benchmark
```bash
>php benchmark.php 1000000
Execution time 0.52344298362732
```
