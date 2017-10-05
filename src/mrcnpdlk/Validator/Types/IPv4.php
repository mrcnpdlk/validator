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

/**
 * Created by Marcin.
 * Date: 01.10.2017
 * Time: 13:23
 */

namespace mrcnpdlk\Validator\Types;


use mrcnpdlk\Validator\Exception;
use mrcnpdlk\Validator\TypeInterface;

class IPv4 extends TypeAbstract implements TypeInterface
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
            if (is_int($checkedValue)) {
                $sIp = long2ip($checkedValue);
            } elseif (is_string($checkedValue)) {
                $sIp = static::clean($checkedValue);
            } else {
                throw new \Exception(sprintf('Invalid input argument type [%s]', gettype($checkedValue)));
            }

            if (filter_var($sIp, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4) === false) {
                throw new \Exception(sprintf('Filter error!'));
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid IPv4 address [%s], reason: %s", $checkedValue, $e->getMessage()));
            }

            return false;
        }
    }

    /**
     * @param mixed $checkedValue
     *
     * @return string
     * @throws Exception
     */
    public static function clean($checkedValue)
    {
        if (is_string($checkedValue)) {
            //remove leading zeros from IP address
            $sIp = preg_replace('/\b0+\B/', '', $checkedValue);
        } elseif (is_int($checkedValue)) {
            $sIp = long2ip($checkedValue);
        } else {
            throw new Exception(sprintf('Invalid input argument type [%s]', gettype($checkedValue)));
        }

        return $sIp;
    }

    /**
     * Return IPv4 addres with leading zeros
     *
     * @return string
     */
    public function getLeadingZeros()
    {
        $parts = explode('.', $this->get());
        foreach ($parts as &$part) {
            $part = str_pad($part, 3, '0', \STR_PAD_LEFT);
        }

        return implode('.', $parts);
    }

    /**
     * Return IPv4 address as int representation
     *
     * @return int
     */
    public function getAsInt()
    {
        return ip2long($this->get());
    }

    /**
     * Check if IPv4 address is local
     *
     * @return bool
     */
    public function isLocalIPAddress()
    {
        if (strpos($this->get(), '127.0.') === 0) {
            return true;
        }

        return (!filter_var($this->get(), \FILTER_VALIDATE_IP, \FILTER_FLAG_NO_PRIV_RANGE | \FILTER_FLAG_NO_RES_RANGE));
    }

}
