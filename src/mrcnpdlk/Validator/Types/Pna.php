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

/**
 * Class Pna
 *
 * Polish postal code validator
 *
 * @package mrcnpdlk\Validator\Types
 */
class Pna extends TypeAbstract implements TypeInterface
{
    /**
     * @param mixed $checkedValue
     * @param bool  $asEx
     *
     * @return bool
     * @throws Exception
     */
    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            if (!preg_match('/^[0-9]{5}$/', $checkedValue) && !preg_match('/^[0-9]{2}-[0-9]{3}$/', $checkedValue)) {
                throw new \Exception("Regexp error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid PNA number [%s], reason: %s", $checkedValue, $e->getMessage()));
            } else {
                return false;
            }
        }
    }

    /**
     * Usuwamy niepotrzebne separatory
     *
     * @param mixed $checkedValue
     *
     * @return string
     */
    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return preg_replace('/[^0-9]/', '', trim($checkedValue));
    }

    /**
     * @return string
     */
    public function getLong()
    {
        return sprintf('%s-%s', substr($this->getShort(), 0, 2), substr($this->getShort(), 2, 3));
    }

    /**
     * Return short version of PNA
     *
     * @return string
     */
    public function getShort()
    {
        return $this->get();
    }
}
