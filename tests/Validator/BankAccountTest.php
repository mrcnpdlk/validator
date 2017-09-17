<?php

namespace mrcnpdlk\Validator;


use mrcnpdlk\Validator\Types\BankAccount;

class BankAccountTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testBankAccountValid()
    {
        $defNr = '13 1020-2791 2123 5389 7801 0731';
        $res = new BankAccount($defNr);
        $this->assertEquals('13102027912123538978010731',$res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testBankAccountInvalid()
    {
        $res = new BankAccount('13102027912123538978010730');
    }

}
