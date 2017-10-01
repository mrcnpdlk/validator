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


use mrcnpdlk\Validator\Types\Date;

class DateTest extends TestCase
{
    public function testPnaValidShort()
    {
        $defNr = '2017-10-01';
        $this->assertTrue(Date::isValid($defNr, false));
        $res   = new Date($defNr);
        $this->assertEquals('2017-10-01', $res->get());
        $this->assertEquals('2017', $res->getYear());
        $this->assertEquals('10', $res->getMonth());
        $this->assertEquals('01', $res->getDay());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testDateInvalid()
    {
        Date::isValid('2017-10-34', true);
    }

}
