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

class DateTime extends \DateTime implements TypeInterface
{
    /**
     * Date constructor.
     *
     * @param string             $time
     * @param \DateTimeZone|null $timezone
     */
    public function __construct($time = 'now', \DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    /**
     * @param string             $time
     * @param \DateTimeZone|null $timezone
     *
     * @return static
     */
    public static function create($time = 'now', \DateTimeZone $timezone = null)
    {
        return new static($time, $timezone);
    }

    /**
     * @param mixed $value
     * @param bool  $asEx
     *
     * @return bool
     * @throws Exception
     */
    public static function isValid($value, bool $asEx = false): bool
    {
        try {
            if (!is_string($value)) {
                throw new \Exception(sprintf('Parsed value is not a string, [%s] given', gettype($value)));
            }
            new Date($value);

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid Date format [%s], reason: %s", $value, $e->getMessage()));
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
        return $checkedValue;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->format('Y');
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->format('m');
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->format('d');
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->format('H:i:s');
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->format('H');
    }

    /**
     * @return string
     */
    public function getMinute()
    {
        return $this->format('i');
    }

    /**
     * @return string
     */
    public function getSecond()
    {
        return $this->format('s');
    }
}
