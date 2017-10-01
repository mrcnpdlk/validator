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

use mrcnpdlk\Validator\Types\Mac;

class MacTest extends TestCase
{
    public function testMacValid()
    {
        $defNr = '00:01:02:aa:BB:EF';
        $this->assertTrue(Mac::isValid($defNr, false));
        $res = new Mac($defNr);
        $this->assertEquals('000102aabbef', $res->get());
        $this->assertEquals('000102AABBEF', $res->getShort(true));
        $this->assertEquals('00-01-02-AA-BB-EF', $res->getLong('-', true));
        $this->assertEquals('00-01-02-aa-bb-ef', $res->getLong('-', false));
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testMacInvalidValidOne()
    {
        Mac::isValid('00:1122:33:44:55:66', true);
    }

    public function testMacInvalidValidTwo()
    {
        $this->assertFalse(Mac::isValid('00:1122:33:44:55:66', false));
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testMacInvalidRegexOne()
    {
        new Mac('001122334455667');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testMacInvalidRegexTwo()
    {
        new Mac('0011223344556g');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testMacInvalidRegexThree()
    {
        new Mac(112233445566);
    }

    public function testVendor()
    {
        $sVendor = Mac::create('00:02:9b:3a:a0:d7')->getVendor();
        $this->assertTrue(is_string($sVendor) || is_null($sVendor));
    }

}
