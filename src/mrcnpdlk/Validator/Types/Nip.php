<?php
/**
 * Validator
 *
 * Copyright (c) 2017 pudelek.org.pl
 *
 * @license MIT License (MIT)
 *
 * For the full copyright and license information, please view source file
 * that is bundled with this package in the file LICENSE
 *
 * @author  Marcin Pudełek <marcin@pudelek.org.pl>
 */

namespace mrcnpdlk\Validator\Types;


use mrcnpdlk\Validator\Exception;
use mrcnpdlk\Validator\TypeInterface;

class Nip extends TypeAbstract implements TypeInterface
{

    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            if (!preg_match('/^[0-9]{10}$/', $checkedValue) || $checkedValue === '0000000000') {
                //check 10 digits
                throw new \Exception("Regexp error", 1);
            }
            $steps    = [6, 5, 7, 2, 3, 4, 5, 6, 7];
            $checkSum = 0;

            for ($i = 0; $i < 9; $i++) {
                $checkSum += $steps[$i] * intval($checkedValue[$i]);
            }
            $checkSum = $checkSum % 11;
            /**
             * http://zylla.wipos.p.lodz.pl/ut/nip-rego.html
             *
             * Uwaga:
             * a co zrobić gdy wynik dzielenia modulo 11 wyjdzie 10 ?
             * Jest to niemożliwe gdyż numery NIP są tak generowane aby
             * nigdy nie zaszedł przypadek, żeby (suma mod 11) wyszła 10.
             * Po prostu Urząd nadaje kolejny numer i sprawdza czy
             * (suma mod 11) wyszło 10. Jeśli tak to numer jest zwiększany
             * o 1 i obliczna jest nowa cyfra kontrolna.
             *
             * Uwaga: 2010 w internecie jest kilka błędnych skryptów,
             * które błędnie weryfikują numer NIP 1234567890 jako prawidłowy.
             * A to jest szczególny przypadek gdy Suma MOD 11 = 10
             */
            if ($checkSum !== intval($checkedValue[9]) || $checkSum === 10) {
                throw new \Exception("Checksum Error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid NIP number [%s], reason: %s", $checkedValue, $e->getMessage()));
            }

            return false;
        }
    }

    /**
     * @param mixed $checkedValue
     *
     * @return mixed
     */
    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return preg_replace('/[\s-]/', "", $checkedValue);
    }

    /**
     * @return null|string
     */
    public function getTaxOffice()
    {
        $dbFilename    = __DIR__ . '/../Databases/us.json';
        $json          = json_decode(file_get_contents($dbFilename));
        $taxOfficeCode = substr($this->checkedValue, 0, 3);
        if (property_exists($json, $taxOfficeCode)) {
            return $json->{$taxOfficeCode}->name;
        } else {
            return null;
        }
    }
}
