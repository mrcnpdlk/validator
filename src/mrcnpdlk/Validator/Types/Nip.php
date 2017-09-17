<?php

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
            $checkSum = ($checkSum % 11) % 10;
            if ($checkSum !== intval($checkedValue[9])) {
                throw new \Exception("Checksum Error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid NIP number [%s], reason: %s", $checkedValue, $e->getMessage()));
            } else {
                return false;
            }
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

        return preg_replace('/[^0-9]/', "", $checkedValue);
    }
}
