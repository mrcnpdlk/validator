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

class Pesel extends TypeAbstract implements TypeInterface
{
    /**
     * Płeć - mężczyzna (male)
     */
    const SEX_M = 'M';
    /**
     * Płeć - kobieta (female)
     */
    const SEX_F = 'F';

    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            if (!preg_match('/^[0-9]{11}$/', $checkedValue) || $checkedValue === '00000000000') {
                //check 11 digits
                throw new \Exception("Regexp error", 1);
            }
            $weights  = [9, 7, 3, 1, 9, 7, 3, 1, 9, 7]; // weights
            $checkSum = static::getChecksum($checkedValue, $weights, 10);
            if ($checkSum !== intval(substr($checkedValue, -1))) {
                throw new \Exception("Checksum Error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid PESEL number [%s], reason: %s", $checkedValue, $e->getMessage()));
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

        return preg_replace('/[\s]/', "", $checkedValue);
    }

    /**
     * Getting person sex
     *
     * @return string
     */
    public function getSex()
    {
        if ((intval($this->checkedValue[9]) % 2) === 0) {
            return static::SEX_F;
        }

        return static::SEX_M;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->parseBirthDate()->format('Y-m-d');
    }

    /**
     * Getting birth date
     *
     * @return \DateTime
     * @throws Exception
     */
    private function parseBirthDate()
    {
        $inYear  = intval($this->checkedValue [0] . $this->checkedValue [1]);
        $inMonth = intval($this->checkedValue [2] . $this->checkedValue [3]);
        $inDay   = intval($this->checkedValue [4] . $this->checkedValue [5]);

        if ($inMonth >= 81 && $inMonth <= 92) {
            $month = $inMonth - 80;
            $year  = $inYear + 1800;
        } elseif ($inMonth >= 1 && $inMonth <= 12) {
            $month = $inMonth;
            $year  = $inYear + 1900;
        } elseif ($inMonth >= 21 && $inMonth <= 32) {
            $month = $inMonth - 20;
            $year  = $inYear + 2000;
        } else {
            throw new Exception("Invaild PESEL number - birthday part out of range");
        }
        if (!checkdate($month, $inDay, $year)) {
            throw new Exception("Invaild PESEL number - birthday part is invaild");
        }

        return new \DateTime(implode('-', [$year, $month, $inDay]));
    }

    /**
     * Getting current age
     *
     * @return int
     */
    public function getAge()
    {
        $interval = $this->parseBirthDate()->diff(new \DateTime("now"));

        return $interval->y;
    }

}
