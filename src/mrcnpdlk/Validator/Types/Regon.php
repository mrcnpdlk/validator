<?php

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
                $weights = [];
                if (strlen($checkedValue) == 9) {
                    $weights = [8, 9, 2, 3, 4, 5, 6, 7]; //wagi stosowane dla REGONów 9-znakowych
                } elseif (strlen($checkedValue) == 14) {
                    $weights = [2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8]; //wagi stosowane dla REGONów 14-znakowych
                }
                $sum = 0;
                for ($i = 0; $i < count($weights); $i++) {
                    $sum += $weights[$i] * intval($checkedValue[$i]);
                }
                $checksum = ($sum % 11) % 10;

                if ($checksum !== intval($checkedValue[count($weights)])) {
                    //jezeli suma kontrolna nie jest rowna ostatniej cyfrze w numerze REGON to numerek jest błędny
                    throw new \Exception("Checksum Error", 1);
                }

                return true;
            } else {
                throw new \Exception(sprintf("Regexp error"), 1);
            }
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid REGON number [%s], reason: %s", $checkedValue, $e->getMessage()));
            } else {
                return false;
            }
        }
    }

    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return str_pad(preg_replace('/[\s]/', "", $checkedValue), 9, '0', \STR_PAD_LEFT);
    }
}
