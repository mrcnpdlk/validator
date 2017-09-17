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
 * @author Marcin Pudełek <marcin@pudelek.org.pl>
 */

declare (strict_types=1);

namespace mrcnpdlk\Validator\Types;

use mrcnpdlk\Validator\Exception;
use mrcnpdlk\Validator\TypeInterface;

/**
 * Class Krs
 *
 * @package mrcnpdlk\Validator\Types
 */
class Krs extends TypeAbstract implements TypeInterface
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
            static::isValidType($checkedValue, static::TYPE_STRING, true);

            if (!preg_match('/^[0-9]{10}/', $checkedValue)) {
                throw new \Exception("Regexp error", 1);
            }

            return true;
        } catch (\Exception $e) {
            if ($asEx) {
                throw new Exception(sprintf("Invalid KRS number [%s], reason: %s", $checkedValue, $e->getMessage()));
            } else {
                return false;
            }
        }
    }

    /**
     * @param $checkedValue
     *
     * @return mixed
     */
    public static function clean($checkedValue)
    {
        static::isValidType($checkedValue, static::TYPE_STRING, true);

        return str_pad(preg_replace('/[\s]/', "", $checkedValue),10,'0',\STR_PAD_LEFT);
    }

}
