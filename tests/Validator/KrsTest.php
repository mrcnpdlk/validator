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

use mrcnpdlk\Validator\Types\Krs;

class KrsTest extends TestCase
{
    public function testKrsValid()
    {
        $defNr = '311911';
        $res   = new Krs($defNr);
        $this->assertEquals('0000311911', $res->get());
    }

    public function testCreate()
    {
        $res = Krs::create('0012345678');
        $this->assertEquals('0012345678', $res->get());
    }


    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testKrsInvalid()
    {
        new Krs('000031d1911');
    }

}
