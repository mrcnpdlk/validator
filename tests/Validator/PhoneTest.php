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

use mrcnpdlk\Validator\Types\Phone;

class PhoneTest extends TestCase
{
    public function testCreate()
    {
        $res = Phone::create('48123123123');
        $this->assertEquals('123123123', $res->get());
    }

    public function testMobile()
    {
        $defNr = '48601123123';
        $res   = new Phone($defNr);
        $this->assertTrue($res->isMobile());
        $this->assertFalse($res->isFixed());
        $this->assertFalse($res->isVoip());
        $this->assertFalse($res->isUAN());
        $this->assertFalse($res->isSharedCost());
        $this->assertFalse($res->isPremiumRate());
        $this->assertFalse($res->isTollFree());
    }
    public function testFixed()
    {
        $defNr = '48421123123';
        $res   = new Phone($defNr);
        $this->assertFalse($res->isMobile());
        $this->assertTrue($res->isFixed());
        $this->assertFalse($res->isVoip());
        $this->assertFalse($res->isUAN());
        $this->assertFalse($res->isSharedCost());
        $this->assertFalse($res->isPremiumRate());
        $this->assertFalse($res->isTollFree());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPhoneEmpty()
    {
        new Phone('');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPhoneInvalid()
    {
        new Phone('44123123123');
    }

    public function testPhoneValid()
    {
        $defNr = '48123123123';
        $res   = new Phone($defNr);
        $this->assertEquals('123123123', $res->get());
    }

}
