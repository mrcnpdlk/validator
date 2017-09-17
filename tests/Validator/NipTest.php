<?php

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
        $res = new Nip('526104088');
    }

}
