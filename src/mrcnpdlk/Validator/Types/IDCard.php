<?php

namespace mrcnpdlk\Validator\Types;


use mrcnpdlk\Validator\Exception;
use mrcnpdlk\Validator\TypeInterface;

class IDCard extends TypeAbstract implements TypeInterface
{
    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING);
            if (!preg_match('/^[A-NPR-Z]{3}[0-9]{6}$/', $checkedValue)) {
                throw new \Exception("Regexp error", 1);
            }

            $defValues = [
                '0' => 0,
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                'A' => 10,
                'B' => 11,
                'C' => 12,
                'D' => 13,
                'E' => 14,
                'F' => 15,
                'G' => 16,
                'H' => 17,
                'I' => 18,
                'J' => 19,
                'K' => 20,
                'L' => 21,
                'M' => 22,
                'N' => 23,
                'O' => 24,
                'P' => 25,
                'Q' => 26,
                'R' => 27,
                'S' => 28,
                'T' => 29,
                'U' => 30,
                'V' => 31,
                'W' => 32,
                'X' => 33,
                'Y' => 34,
                'Z' => 35,
            ];

            $importances       = [7, 3, 1, 9, 7, 3, 1, 7, 3];
            $identity_card_sum = 0;

            foreach (str_split($checkedValue) as $i => $digit) {
                $identity_card_sum += $defValues[$digit] * $importances[$i];
            };

            if ($identity_card_sum % 10 !== 0) {
                throw new \Exception(sprintf('Checksum error'), 1);
            }


            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid ID Card number [%s], reason: %s", $checkedValue, $e->getMessage()));
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
        static::isValidType($checkedValue, static::TYPE_STRING);

        return preg_replace('/[^A-Z0-9]/', "", strtoupper($checkedValue));
    }
}
