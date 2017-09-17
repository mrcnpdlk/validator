<?php

namespace mrcnpdlk\Validator;

use mrcnpdlk\Validator\Types\Regon;

class RegonTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testRegonValid()
    {
        $defNr = '331501';
        $res   = new Regon($defNr);
        $this->assertEquals('000331501', $res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testRegonInvalid()
    {
        $res = new Regon('000331502');
    }

}
