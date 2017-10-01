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


use mrcnpdlk\Validator\Types\DateTime;

class DateTimeTest extends TestCase
{
    public function testPnaValidShort()
    {
        $this->assertTrue(DateTime::isValid('2017-10-01', false));
        $res   = new DateTime('2017-10-01');
        $this->assertEquals('2017-10-01 00:00:00', $res->get());

        $res   = new DateTime('2017-10-01 22:15:45');
        $this->assertEquals('2017-10-01 22:15:45', $res->get());
        $this->assertEquals('2017', $res->getYear());
        $this->assertEquals('10', $res->getMonth());
        $this->assertEquals('01', $res->getDay());
        $this->assertEquals('22:15:45', $res->getTime());
        $this->assertEquals('22', $res->getHour());
        $this->assertEquals('15', $res->getMinute());
        $this->assertEquals('45', $res->getSecond());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testDateInvalid()
    {
        DateTime::isValid('2017-10-01 00:01:78', true);
    }

}
