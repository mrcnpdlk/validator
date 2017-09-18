
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

## Running the tests

```php
./vendor/bin/phpunit
```

## Authors

* **Marcin Pudełek** - *Initial work* - [mrcnpdlk](https://github.com/mrcnpdlk)

See also the list of [contributors](https://github.com/mrcnpdlk/validator/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](https://github.com/mrcnpdlk/validator/blob/master/LICENSE) file for details

