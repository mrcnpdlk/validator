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

use mrcnpdlk\Validator\Types\Nip;

class NipTest extends TestCase
{
    public function testNipValid()
    {
        $defNr = '526-10-40-828';
        $res   = new Nip($defNr);
        $this->assertEquals('5261040828', $res->get());
        $this->assertEquals('string', gettype($res->getTaxOffice()));
    }

    public function testIsValid()
    {
        $this->assertTrue(Nip::isValid('5261040828',false));
        $this->assertFalse(Nip::isValid('5261040827',false));
    }

    public function testCreate()
    {
        $res = Nip::create('7844072717');
        $this->assertEquals('7844072717', $res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testNipInvalidChecksum()
    {
        new Nip('5261040829');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testNipInvalidRegex()
    {
        new Nip('526104088');
    }

}
