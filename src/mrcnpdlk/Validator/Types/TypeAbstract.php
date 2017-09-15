<?php
namespace mrcnpdlk\Validator\Types;


use mrcnpdlk\Validator\TypeInterface;

/**
 * Class TypeAbstract
 *
 * @package mrcnpdlk\Validator\Types
 */
class TypeAbstract implements TypeInterface
{

    /**
     * Checked Value
     *
     * @var mixed
     */
    protected $checkedValue;

    public function __construct($checkedValue)
    {
        static::isValid($checkedValue, true);
        $this->checkedValue = static::clean($checkedValue);
    }

    public static function isValid($checkedValue, bool $asEx = false) : bool
    {
        return false;
    }

    public static function clean($checkedValue)
    {
        return $checkedValue;
    }

    public function __toString()
    {
        return $this->get();
    }

    public function get()
    {
        return $this->checkedValue;
    }

}