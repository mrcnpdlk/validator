<?php

namespace mrcnpdlk\Validator\Types;

use mrcnpdlk\Validator\Exception;
use mrcnpdlk\Validator\TypeInterface;

class Pesel extends TypeAbstract implements TypeInterface
{
    public static function isValid($checkedValue, bool $asEx = false) : bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            if (!preg_match('/^[0-9]{11}$/', $checkedValue)) {
                //check 11 digits
                throw new \Exception("Regexp error", 1);
            }
            $arrSteps = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3]; // weights
            $intSum   = 0;
            for ($i = 0; $i < 10; $i++) {
                $intSum += $arrSteps[$i] * (int) $checkedValue[$i]; //multiply each digit by weight and sum
            }
            $int          = 10 - $intSum % 10; //calculate checksum
            $intControlNr = ($int === 10) ? 0 : $int;
            if ($intControlNr !== (int) $checkedValue[10]) {
                throw new \Exception("Checksum Error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid PESEL number [%s], reason: %s", $checkedValue, $e->getMessage()));
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
