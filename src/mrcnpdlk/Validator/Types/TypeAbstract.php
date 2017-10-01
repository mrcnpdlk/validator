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
 * Class TypeAbstract
 *
 * @package mrcnpdlk\Validator\Types
 */
class TypeAbstract implements TypeInterface
{

    const TYPE_STRING  = 'string';
    const TYPE_INT     = 'int';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT   = 'float';
    const TYPE_DOUBLE  = 'float';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_OBJECT  = 'object';
    const TYPE_BOOL    = 'bool';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_NULL    = 'null';
    const TYPE_ARRAY   = 'array';
    /**
     * Checked Value
     *
     * @var mixed
     */
    protected $checkedValue;

    public function __construct($checkedValue)
    {
        $this->checkedValue = static::clean($checkedValue);
        static::isValid($this->checkedValue, true);

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
     * @param mixed $checkedValue
     * @param bool  $asEx
     *
     * @return bool
     */
    public static function isValid($checkedValue, bool $asEx = false): bool
    {
        return false;
    }

    /**
     * Check if value has required type
     *
     * @param        $checkedValue
     * @param string $requiredType string, int, bool etc
     * @param bool   $asEx         Response as Exception
     *
     * @return bool
     * @throws \mrcnpdlk\Validator\Exception
     */
    protected static function isValidType($checkedValue, string $requiredType, bool $asEx = false)
    {
        $requiredType = strtolower($requiredType);

        switch ($requiredType) {
            case TypeAbstract::TYPE_INT:
            case TypeAbstract::TYPE_INTEGER:
                $status = is_int($checkedValue);
                break;
            case TypeAbstract::TYPE_FLOAT:
                $status = is_float($checkedValue);
                break;
            case TypeAbstract::TYPE_DOUBLE:
                $status = is_double($checkedValue);
                break;
            case TypeAbstract::TYPE_NUMERIC:
                $status = is_numeric($checkedValue);
                break;
            case TypeAbstract::TYPE_STRING:
                $status = is_string($checkedValue);
                break;
            case TypeAbstract::TYPE_OBJECT:
                $status = is_object($checkedValue);
                break;
            case TypeAbstract::TYPE_BOOL:
            case TypeAbstract::TYPE_BOOLEAN:
                $status = is_bool($checkedValue);
                break;
            case TypeAbstract::TYPE_NULL:
                $status = is_null($checkedValue);
                break;
            case TypeAbstract::TYPE_ARRAY:
                $status = is_array($checkedValue);
                break;
            default:
                throw new Exception(sprintf('Unsupported type of value [%s]', $requiredType));
        }

        if (!$status && $asEx) {
            throw new Exception(sprintf('Invalid type of value, is [%s], should be [%s]', gettype($checkedValue), $requiredType));
        }

        return $status;
    }

    public function __toString()
    {
        return $this->get();
    }

    public function get()
    {
        return strval($this->checkedValue);
    }

    /**
     * @param string $checkedValue
     * @param array  $weights
     * @param int    $modulo
     *
     * @return int
     */
    public static function getChecksum(string $checkedValue, array $weights, int $modulo = 11)
    {
        $sum          = 0;
        $countWeights = count($weights);
        for ($i = 0; $i < $countWeights; $i++) {
            $sum += $weights[$i] * intval($checkedValue[$i]);
        }

        return $sum % $modulo;
    }

}
