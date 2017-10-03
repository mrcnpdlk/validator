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

use mrcnpdlk\Validator\Types\Regon;

class RegonTest extends TestCase
{
    public function testRegonValid()
    {
        $defNr = '331501';
        $res   = new Regon($defNr);
        $this->assertEquals('000331501', $res->get());
    }

    public function testRegonLongValid()
    {
        $defNr = '47051837100020';
        $res   = new Regon($defNr);
        $this->assertEquals('470518371', $res->getShort());
        $this->assertEquals('47051837100020', $res->getLong());
    }

    public function testCreate()
    {
        $res = Regon::create('45700482854889');
        $this->assertEquals('45700482854889', $res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testRegonInvalidChecksum()
    {
        new Regon('000331502');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testRegonInvalidRegex()
    {
        new Regon('0003315021');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testRegonEmpty()
    {
        new Regon('');
    }

}
