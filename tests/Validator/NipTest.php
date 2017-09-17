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
    public function setUp()
    {
        parent::setUp();
    }

    public function testNipValid()
    {
        $defNr = '526-10-40-828';
        $res   = new Nip($defNr);
        $this->assertEquals('5261040828', $res->get());
        $this->assertEquals('string', gettype($res->getTaxOffice()));
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testNipInvalid()
    {
        new Nip('526104088');
    }

}
