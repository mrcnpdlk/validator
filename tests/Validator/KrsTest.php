<?php

namespace mrcnpdlk\Validator;

use mrcnpdlk\Validator\Types\Krs;

class KrsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testKrsValid()
    {
        $defNr = '311911';
        $res   = new Krs($defNr);
        $this->assertEquals('0000311911', $res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testKrsInvalid()
    {
        $res = new Krs('000031d1911');
    }

}
