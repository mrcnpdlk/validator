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

class BankAccount extends TypeAbstract implements TypeInterface
{
    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            $checkedValue = static::clean($checkedValue);

            if (!preg_match('/^[0-9]{26}$/', $checkedValue)) {
                //check 11 digits
                throw new \Exception(sprintf("Regexp error"), 1);
            }
            $weights = [
                1,
                10,
                3,
                30,
                9,
                90,
                27,
                76,
                81,
                34,
                49,
                5,
                50,
                15,
                53,
                45,
                62,
                38,
                89,
                17,
                73,
                51,
                25,
                56,
                75,
                71,
                31,
                19,
                93,
                57,
            ];

            $checkedValue .= "2521";
            $cnrb         = substr($checkedValue, 2) . substr($checkedValue, 0, 2);
            $checkSum     = 0;
            for ($i = 0; $i < 30; $i++) {
                $checkSum += $cnrb[29 - $i] * $weights[$i];
            }

            if ($checkSum % 97 !== 1) {
                throw new \Exception("Checksum Error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid NRB number [%s], reason: %s", $checkedValue, $e->getMessage()));
            }

            return false;
        }
    }

    /**
     * Remove separators
     *
     * @param mixed $checkedValue
     *
     * @return string
     *
     */
    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return preg_replace('/[\s-]/', "", $checkedValue);
    }
}
