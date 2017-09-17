<?php

namespace mrcnpdlk\Validator;


use mrcnpdlk\Validator\Types\IDCard;

class IDCardTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testIDCardValid()
    {
        $defNr = 'aha051591';
        $res = new IDCard($defNr);
        $this->assertEquals('AHA051591',$res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testIDCardInvalid()
    {
        $res = new IDCard('AHA051590');
    }

}
