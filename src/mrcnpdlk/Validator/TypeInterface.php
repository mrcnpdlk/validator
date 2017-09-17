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
     * Checking if ID is valid
     *
     * @param mixed $checkedValue Checked value
     * @param bool  $asEx         return FALSE or Exception
     *
     * @return bool
     */
    public static function isValid($checkedValue, bool $asEx = false): bool;

    /**
     * Cleaning ID from unnecessary chars
     *
     * @param mixed $checkedValue
     *
     * @return mixed
     */
    public static function clean($checkedValue);

    /**
     * Returning cleaning and valid ID
     *
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function __toString();
}
