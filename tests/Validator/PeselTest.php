<?php

namespace mrcnpdlk\Validator;

use mrcnpdlk\Validator\Types\Pesel;

class PeselTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testPeselValid()
    {
        $defNr = '12271402999';
        $res   = new Pesel($defNr);
        $this->assertEquals('12271402999', $res->get());
        $this->assertEquals('2012-07-14', $res->getBirthDate());
        $this->assertEquals(Pesel::SEX_M, $res->getSex());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testPeselInvalid()
    {
        $res = new Pesel('12271402990');
    }

}
