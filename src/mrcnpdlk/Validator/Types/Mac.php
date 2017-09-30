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

declare (strict_types=1);

namespace mrcnpdlk\Validator\Types;

use mrcnpdlk\Validator\Exception;
use mrcnpdlk\Validator\TypeInterface;

/**
 * Class Mac
 *
 * @package mrcnpdlk\Validator\Types
 */
class Mac extends TypeAbstract implements TypeInterface
{
    /**
     * @param mixed $checkedValue
     * @param bool  $asEx
     *
     * @return bool
     * @throws \mrcnpdlk\Validator\Exception
     */
    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        try {
            $checkedValue = static::clean($checkedValue);

            if (!preg_match('/^[a-f0-9]{12}$/i', $checkedValue)) {
                throw new \Exception("Regexp error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid MAC address [%s], reason: %s", $checkedValue, $e->getMessage()));
            }

            return false;
        }
    }

    /**
     * Triming and removing separators
     *
     * @param $checkedValue
     *
     * @return mixed
     */
    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return preg_replace('/[^a-f\d]/i', '', trim(strtolower($checkedValue)));
    }

    /**
     * @param bool $setUpper
     *
     * @return mixed|string
     */
    public function getShort(bool $setUpper = false)
    {
        return $setUpper ? strtoupper($this->get()) : $this->get();
    }

    /**
     * @param bool   $setUpper
     * @param string $separator
     *
     * @return string
     */
    public function getLong(bool $setUpper = false, string $separator = ':')
    {
        return implode($separator, str_split($setUpper ? strtoupper($this->get()) : $this->get(), 2));
    }

    /**
     * Get device vendor
     *
     * @return string|null
     */
    public function getVendor()
    {
        $url = sprintf('%s%s',"http://api.macvendors.com/" , $this->get());
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if ($response) {
            return $response;
        }

        return null;
    }
}
