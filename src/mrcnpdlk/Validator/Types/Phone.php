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
 * Class Phone
 *
 * Polish phone number validator
 *
 * @package mrcnpdlk\Validator\Types
 */
class Phone extends TypeAbstract implements TypeInterface
{
    const COUNTRY_PREFIX         = '48';
    const NATIONAL_NUMBER_LENGTH = 9;
    const REGEX_FIXED            = '/(?:1[2-8]|2[2-69]|3[2-4]|4[1-468]|5[24-689]|6[1-3578]|7[14-7]|8[1-79]|9[145])(?:\d{7})/';
    const REGEX_MOBILE           = '/(?:45|5[0137]|6[069]|7[2389]|88)\d{7}/';
    const REGEX_TOLL_FREE        = '/800\d{6}/';
    const REGEX_PREMIUM_RATE     = '/70[01346-8]\d{6}/';
    const REGEX_SHARED_COST      = '/801\d{6}/';
    const REGEX_VOIP             = '/39\d{7}/';
    const REGEX_UAN              = '/804\d{6}/';

    public function __construct($checkedValue)
    {
        parent::__construct($checkedValue);
        $this->checkedValue = substr($this->checkedValue, -9);
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

        return preg_replace('/[\s]/', '', trim($checkedValue));
    }

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
            if (!preg_match('/^' . static::COUNTRY_PREFIX . '[\d]{9}$/', $checkedValue)
                && !preg_match('/^[\d]{9}$/', $checkedValue)) {
                throw new \Exception('regex error');
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid phone number [%s], reason: %s", $checkedValue, $e->getMessage()));
            } else {
                return false;
            }
        }
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return static::COUNTRY_PREFIX;
    }

    /**
     * @return string
     */
    public function getInternationalFormat()
    {
        return sprintf('%s%s', static::COUNTRY_PREFIX, $this->get());
    }

    /**
     * @return mixed|string
     */
    public function getNationalFormat()
    {
        return $this->get();
    }

    /**
     * @return bool
     */
    public function isFixed()
    {
        return preg_match(static::REGEX_FIXED, $this->checkedValue) === 1;
    }

    /**
     * @return bool
     */
    public function isMobile()
    {
        return preg_match(static::REGEX_MOBILE, $this->checkedValue) === 1;
    }

    /**
     * @return bool
     */
    public function isPremiumRate()
    {
        return preg_match(static::REGEX_PREMIUM_RATE, $this->checkedValue) === 1;
    }

    /**
     * @return bool
     */
    public function isSharedCost()
    {
        return preg_match(static::REGEX_SHARED_COST, $this->checkedValue) === 1;
    }

    /**
     * @return bool
     */
    public function isTollFree()
    {
        return preg_match(static::REGEX_TOLL_FREE, $this->checkedValue) === 1;
    }

    /**
     * @return bool
     */
    public function isUAN()
    {
        return preg_match(static::REGEX_UAN, $this->checkedValue) === 1;
    }

    /**
     * @return bool
     */
    public function isVoip()
    {
        return preg_match(static::REGEX_VOIP, $this->checkedValue) === 1;
    }
}
