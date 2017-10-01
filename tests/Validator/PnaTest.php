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

use mrcnpdlk\Validator\Types\Pna;

class PnaTest extends TestCase
{
    public function testPnaValidShort()
    {
        $defNr = '90019';
        $this->assertTrue(Pna::isValid($defNr, false));
        $res   = new Pna($defNr);
        $this->assertEquals('90019', $res->get());
        $this->assertEquals('90019', $res->getShort());
        $this->assertEquals('90-019', $res->getLong());
    }
    public function testPnaValidLong()
    {
        $defNr = '90-019';
        $this->assertTrue(Pna::isValid($defNr, false));
        $res   = new Pna($defNr);
        $this->assertEquals('90019', $res->get());
        $this->assertEquals('90019', $res->getShort());
        $this->assertEquals('90-019', $res->getLong());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPnaInvalid()
    {
        Pna::isValid('1-2345', true);
    }

}
