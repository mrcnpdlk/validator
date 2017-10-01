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

use mrcnpdlk\Validator\Types\IPv4;

class IPv4Test extends TestCase
{
    public function testIpv4IntValid()
    {
        $defNr = 1527088647;
        $this->assertTrue(IPv4::isValid($defNr, false));
        $res   = new IPv4($defNr);
        $this->assertEquals('91.5.134.7', $res->get());
        $this->assertEquals('091.005.134.007', $res->getLeadingZeros());
        $this->assertEquals(1527088647, $res->getLong());
    }

    public function testIpv4StringValid()
    {
        $defNr = '91.5.134.007';
        $this->assertTrue(IPv4::isValid($defNr, false));
        $res   = new IPv4($defNr);
        $this->assertEquals('91.5.134.7', $res->get());
        $this->assertEquals('091.005.134.007', $res->getLeadingZeros());
        $this->assertEquals(1527088647, $res->getLong());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testIpv4InvalidValid()
    {
        IPv4::isValid('1.1.1.300',true);
    }
    public function testIpv4Local()
    {
        $this->assertTrue((new IPv4('127.0.0.1'))->isLocalIPAddress());
        $this->assertTrue((new IPv4('10.0.0.1'))->isLocalIPAddress());
        $this->assertTrue((new IPv4('10.255.255.255'))->isLocalIPAddress());
        $this->assertTrue((new IPv4('172.16.0.1'))->isLocalIPAddress());
        $this->assertTrue((new IPv4('172.31.255.255'))->isLocalIPAddress());
        $this->assertTrue((new IPv4('192.168.0.1'))->isLocalIPAddress());
        $this->assertTrue((new IPv4('192.168.255.254'))->isLocalIPAddress());
    }


}
