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

namespace mrcnpdlk\Validator;

use mrcnpdlk\Validator\Types\Pesel;

class PeselTest extends TestCase
{
    public function testPeselMaleValid()
    {
        $defNr = '12271402999';
        $res   = new Pesel($defNr);
        $this->assertEquals('12271402999', $res->get());
        $this->assertEquals('2012-07-14', $res->getBirthDate());
        $this->assertEquals(Pesel::SEX_M, $res->getSex());
        $this->assertEquals(true, $res->getAge() > 3);
    }

    public function testPeselFemaleValid()
    {
        $defNr = '30082916746';
        $res   = new Pesel($defNr);
        $this->assertEquals('30082916746', $res->get());
        $this->assertEquals('1930-08-29', $res->getBirthDate());
        $this->assertEquals(Pesel::SEX_F, $res->getSex());
        $this->assertEquals(true, $res->getAge() > 86);
    }

    public function testPeselOldValid()
    {
        $defNr = '11880804152';
        $res   = new Pesel($defNr);
        $this->assertEquals('11880804152', $res->get());
        $this->assertEquals('1811-08-08', $res->getBirthDate());
        $this->assertEquals(Pesel::SEX_M, $res->getSex());
        $this->assertEquals(true, $res->getAge() > 205);
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPeselInvalidChecksum()
    {
        new Pesel('12271402990');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPeselInvalidRegex()
    {
        new Pesel('3008291674');
    }

}
