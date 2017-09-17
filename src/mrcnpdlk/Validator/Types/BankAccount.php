<?php
/**
 * Created by Marcin.
 * Date: 15.09.2017
 * Time: 22:47
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
            $W = [
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
            $Z            = 0;
            for ($i = 0; $i < 30; $i++) {
                $Z += $cnrb[29 - $i] * $W[$i];
            }

            if ($Z % 97 !== 1) {
                throw new \Exception("Checksum Error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid NRB number [%s], reason: %s", $checkedValue, $e->getMessage()));
            } else {
                return false;
            }
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

        return preg_replace('/[^0-9]/', "", $checkedValue);
    }
}
