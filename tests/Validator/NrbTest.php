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


use mrcnpdlk\Validator\Types\Nrb;

/**
 * Class NrbTest
 *
 * Polish bank account validator
 *
 * @package mrcnpdlk\Validator
 */
class NrbTest extends TestCase
{
    public function testBankAccountValid()
    {
        $defNr = '13 1020-2791 2123 5389 7801 0731';
        $res   = new Nrb($defNr);
        $this->assertEquals('13102027912123538978010731', $res->get());
        $this->assertEquals('102', $res->getBank());
        $this->assertEquals('10202791', $res->getBankDepartment());
    }

    public function testCreate()
    {
        $res = Nrb::create('56249006987922476080369247');
        $this->assertEquals('56249006987922476080369247', $res->get());
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testBankAccountInvalidChecksum()
    {
        new Nrb('13102027912123538978010730');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testBankAccountInvalidRegex()
    {
        new Nrb('131020279121235389780aaa');
    }

    /**
     * @expectedException \mrcnpdlk\Validator\Exception
     */
    public function testBankAccountInvalidBankDepartment()
    {
        new Nrb('04 0000 0000 0000 0000 0000 0000');
    }

}
