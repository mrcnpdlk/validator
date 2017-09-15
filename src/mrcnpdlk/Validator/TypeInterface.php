<?php
declare (strict_types=1);

namespace mrcnpdlk\Validator;

/**
 * Interface TypeInterface
 *
 * @package mrcnpdlk\Validator
 */
interface TypeInterface
{
    /**
     * @param mixed $checkedValue Checked value
     * @param bool  $asEx         return FALSE or Exception
     *
     * @return bool
     */
    public static function isValid($checkedValue, bool $asEx = false): bool;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public static function clean($checkedValue);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function __toString();
}