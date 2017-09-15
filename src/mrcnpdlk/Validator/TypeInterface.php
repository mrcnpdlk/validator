<?php

namespace mrcnpdlk\Validator;


interface TypeInterface
{
    /**
     * @param mixed $value Checked value
     * @param bool  $asEx  return FALSE or Exception
     *
     * @return bool
     */
    public static function isValid($value, bool $asEx = false): bool;

    /**
     * @return mixed
     */
    public function get();
}