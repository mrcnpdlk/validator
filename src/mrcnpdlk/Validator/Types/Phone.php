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

    private $ukeMobilePlan = [];
    private $ukeFixedPlan  = [];

    /**
     * Phone constructor.
     *
     * @param $checkedValue
     */
    public function __construct($checkedValue)
    {
        parent::__construct($checkedValue);
        //pobieramy sam numer krajowy
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
            if (strlen($checkedValue) !== 9 && strlen($checkedValue) !== 11) {
                throw new \Exception(sprintf('invalid length'));
            }
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

    public function getRegion()
    {
        $sRegion = null;
        if ($this->isMobile()) {
            $nr = $this->getNationalFormat();
            while (strlen($nr) > 0 || is_null($sRegion)) {
                if (array_key_exists($nr, $this->getUkeMobilePlan())) {
                    $sRegion = $this->getUkeMobilePlan()[$nr]['operator'];
                }
                $nr = substr($nr, 0, -1);
            }
        } elseif ($this->isFixed()) {
            $sRegion = $this->getUkeFixedPlan()[substr($this->getNationalFormat(),0,2)] ?? null;
        }

        return $sRegion ?? 'Polska';
    }

    /**
     * @return bool
     */
    public function isMobile()
    {
        return preg_match(static::REGEX_MOBILE, $this->checkedValue) === 1;
    }

    /**
     * @return mixed|string
     */
    public function getNationalFormat()
    {
        return $this->get();
    }

    /**
     * @return array
     */
    private function getUkeMobilePlan()
    {
        if (empty($this->ukeMobilePlan)) {
            $oXml = new \SimpleXMLElement(file_get_contents(__DIR__ . '/../Databases/T2-PLMN_T9-MVNO.xml'));

            foreach ($oXml->numery->plmn as $oNr) {
                $t = $this->parseNumberPlan(strval($oNr->numer));
                foreach ($t as $n) {
                    $this->ukeMobilePlan[$n] = [
                        'numer'    => strval($oNr->numer),
                        'operator' => strval($oNr->operator),
                        'typ'      => strval($oNr->typ),
                    ];
                }
            }
        }

        return $this->ukeMobilePlan;
    }

    /**
     * @param string $plan
     *
     * @return array
     * @throws \Exception
     */
    private function parseNumberPlan(string $plan)
    {
        if (preg_match("/(?'prefix'[\d]*)(\((?'suffix'[\d\-,]*)\))?/", strval($plan), $f)) {
            $answer = [];
            $prefix = $f['prefix'];
            $suffix = $f['suffix'] ?? null;
            $tSuf   = [];
            if ($suffix) {
                foreach (explode(',', $suffix) as $digit) {
                    if (preg_match("/((?'first'[\d]{1})\-(?'last'[\d]{1}))/", $digit, $f)) {
                        $first = intval($f['first']);
                        $last  = intval($f['last']);
                        if ($last === 0) {
                            $last   = 9;
                            $tSuf[] = 0;
                        }
                        for ($i = $first; $i <= $last; $i++) {
                            $tSuf[] = $i;
                        }
                    } else {
                        $tSuf[] = intval($digit);
                    }
                }
            }
            if (empty($tSuf)) {
                $answer = [$prefix];
            } else {
                foreach ($tSuf as $d) {
                    $answer[] = $prefix . $d;
                }
            }

            return $answer;
        } else {
            throw new \Exception('regex error');
        }
    }

    /**
     * @return bool
     */
    public function isFixed()
    {
        return preg_match(static::REGEX_FIXED, $this->checkedValue) === 1;
    }

    /**
     * @return array
     */
    private function getUkeFixedPlan()
    {
        if (empty($this->ukeMobilePlan)) {
            include __DIR__ . '/../Databases/ukeFixedPlan.php';
            $this->ukeFixedPlan = $ukeFixedPlan;
        }

        return $this->ukeFixedPlan;
    }
}
