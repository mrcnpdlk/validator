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

namespace mrcnpdlk\Validator;

use mrcnpdlk\Validator\Types\Pesel;

class PeselTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testPeselValid()
    {
        $defNr = '12271402999';
        $res   = new Pesel($defNr);
        $this->assertEquals('12271402999', $res->get());
        $this->assertEquals('2012-07-14', $res->getBirthDate());
        $this->assertEquals(Pesel::SEX_M, $res->getSex());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPeselInvalid()
    {
        $res = new Pesel('12271402990');
    }

}
