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

class Regon extends TypeAbstract implements TypeInterface
{
    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            if (preg_match('/^[0-9]{9}$/', $checkedValue) || preg_match('/^[0-9]{14}$/', $checkedValue)) {
                if (strlen($checkedValue) === 9) {
                    $weights = [8, 9, 2, 3, 4, 5, 6, 7]; //wagi stosowane dla REGONów 9-znakowych
                } else {
                    //dla dlugich numerów sprawdzamy sumę kontrolną dla krótkiego
                    static::isValid(substr($checkedValue, 0, 9), true);
                    $weights = [2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8]; //wagi stosowane dla REGONów 14-znakowych
                }
                $checkSum = static::getChecksum($checkedValue, $weights) % 10;

                if ($checkSum !== intval(substr($checkedValue, -1))) {
                    //jezeli suma kontrolna nie jest rowna ostatniej cyfrze w numerze REGON to numerek jest błędny
                    throw new \Exception("Checksum Error", 1);
                }

                return true;
            }

            throw new \Exception(sprintf("Regexp error"), 1);

        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid REGON number [%s], reason: %s", $checkedValue, $e->getMessage()));
            }

            return false;
        }
    }

    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return str_pad(preg_replace('/[\s]/', "", $checkedValue), 9, '0', \STR_PAD_LEFT);
    }

    /**
     * Return short REGON number
     *
     * @return string
     */
    public function getShort()
    {
        return substr($this->checkedValue, 0, 9);
    }

    /**
     * Return long REGON number
     *
     * @return string
     */
    public function getLong()
    {
        return str_pad($this->checkedValue, 14, '0', \STR_PAD_RIGHT);
    }
}
