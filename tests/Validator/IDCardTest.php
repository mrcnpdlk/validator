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


use mrcnpdlk\Validator\Types\IDCard;

class IDCardTest extends TestCase
{
    public function testIDCardValid()
    {
        $defNr = 'aha 051591  ';
        $res = new IDCard($defNr);
        $this->assertEquals('AHA051591',$res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testIDCardInvalid()
    {
        new IDCard('AHA051590');
    }

}
