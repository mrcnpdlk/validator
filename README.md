
[![Latest Stable Version](https://img.shields.io/github/release/mrcnpdlk/validator.svg)](https://packagist.org/packages/mrcnpdlk/validator)
[![Latest Unstable Version](https://poser.pugx.org/mrcnpdlk/validator/v/unstable.png)](https://packagist.org/packages/mrcnpdlk/validator)
[![Total Downloads](https://img.shields.io/packagist/dt/mrcnpdlk/validator.svg)](https://packagist.org/packages/mrcnpdlk/validator)
[![Monthly Downloads](https://img.shields.io/packagist/dm/mrcnpdlk/validator.svg)](https://packagist.org/packages/mrcnpdlk/validator)
[![License](https://img.shields.io/packagist/l/mrcnpdlk/validator.svg)](https://packagist.org/packages/mrcnpdlk/validator)    

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mrcnpdlk/validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mrcnpdlk/validator/?branch=master) 
[![Build Status](https://scrutinizer-ci.com/g/mrcnpdlk/validator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mrcnpdlk/validator/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/mrcnpdlk/validator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mrcnpdlk/validator/?branch=master)

[![Code Climate](https://codeclimate.com/github/mrcnpdlk/validator/badges/gpa.svg)](https://codeclimate.com/github/mrcnpdlk/validator) 
[![Issue Count](https://codeclimate.com/github/mrcnpdlk/validator/badges/issue_count.svg)](https://codeclimate.com/github/mrcnpdlk/validator)

# Validator

Package include a lot of validators (mainly polish IDs)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

None

### Installing

Bst way:

```php
composer require mrcnpdlk/validator
```
### Supported Types

|Type|Class|Example|
|---|---|---|
|Date|Date|YYYY-MM-DD|
|DateTime|DateTime|YYYY-MM-DD HH:MM:SS|
|Polish identity card|IdCard|XXX12323|
|IP ver 4 address|IPv4|192.168.1.1|
|MAC address|Mac||
|Polish KRS|Krs||
|Polish NIP|Nip||
|Polish REGON|Regon||
|Polish bank account|Nrb||
|Polish PESEL|Pesel||
|Polish postal code|Pna||
|Polish phone|Phone||


### Using

#### PESEL
```php
$res = new \mrcnpdlk\Validator\Types\Pesel('12271402999');
var_dump($res->get()); //return parsed and cleaned string
var_dump($res->getBirthDate()); //return date in format YYY-MM-DD
var_dump($res->getAge()); //return int
var_dump($res->getSex()); //return F/M char
```

#### NIP
```php
$res = new \mrcnpdlk\Validator\Types\Nip('362-005-44-28');
var_dump($res->get()); //return parsed and cleaned string (3620054428)
var_dump($res->getTaxOffice()); //return Tax Office name (Urząd Skarbowy Poznań-Nowe Miasto)
```

#### REGON
```php
$res = new \mrcnpdlk\Validator\Types\Regon('331501');
var_dump($res->get()); //return parsed and cleaned string (000331501)
var_dump($res->getShort()); //return short number (000331501)
var_dump($res->getLong()); //return long number (00033150100000)
```

#### NRB
```php

$oNrb = new \mrcnpdlk\Validator\Types\Nrb('13 1020 2791 2123 5389 7801 0731');
var_dump($oNrb->get());
var_dump($oNrb->getBank());
var_dump($oNrb->getBankDepartment());
```
returns:
```text
string(26) "13102027912123538978010731"
string(3) "102"
string(8) "10202791"

```


#### PHONE
```php
$oPhone = new \mrcnpdlk\Validator\Types\Phone('48 42 6742222');
var_dump($oPhone->isMobile());
var_dump($oPhone->isFixed());
var_dump($oPhone->isPremiumRate());
var_dump($oPhone->isTollFree());
var_dump($oPhone->isSharedCost());
var_dump($oPhone->isUAN());
var_dump($oPhone->isVoip());
var_dump($oPhone->getInternationalFormat());
var_dump($oPhone->getNationalFormat());
var_dump($oPhone->getRegion());
```
returns:
```text
bool(false)
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
string(11) "48426742222"
string(9) "426742222"
string(7) "Łódź"
```

## Running the tests

```bash
./vendor/bin/phpunit
```

## Authors

* **Marcin Pudełek** - *Initial work* - [mrcnpdlk](https://github.com/mrcnpdlk)

See also the list of [contributors](https://github.com/mrcnpdlk/validator/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](https://github.com/mrcnpdlk/validator/blob/master/LICENSE) file for details

