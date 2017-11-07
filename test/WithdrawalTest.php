<?php

use PHPUnit\Framework\TestCase;
use Operation\Withdrawal;

require_once __DIR__.'./../src/withdraw/Withdrawal.php';

final class WithdrawalTest extends TestCase {
    // test get fields
    function testGetAccountNumber() {
        $sut = new Withdrawal('0123444667');
        $this->assertEquals('0123444667', $sut->getAccountNumber());
    }

    // test set fields
    function testSetAccountBalance() {
        $sut = new Withdrawal('0123444667');
        $sut->setAccountBalance(500000);
        $this->assertEquals(500000, $sut->getAccountBalance());
    }

    // test happy path
    function testWithdrawSuccessfully() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('50');
        $this->assertEquals(1999950, $outputs->accountBalance);
    }

    function testWithdrawSuccessfully2() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('50');
        $this->assertEquals('0123444667', $outputs->accountNumber);
    }

    function testWithdrawSuccessfully3() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('50');
        $this->assertEquals('Kritsada Kancha', $outputs->accountName);
    }

    function testWithdrawSuccessfully4() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('1000000');
        $this->assertEquals(1000000, $sut->getAccountBalance());
    }

    // test sadly path
    function testWithdrawInputIsNotNumber() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('abcdefg');
        $this->assertEquals('จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขเท่านั้น', $outputs->errorMessage);
    }

    function testWithdrawInputIsNotNumber2() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('');
        $this->assertEquals('จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขเท่านั้น', $outputs->errorMessage);
    }

    function testWithdrawInputIsNotPositiveInteger() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('-1');
        $this->assertEquals('จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขจำนวนเต็มที่มีค่ามากกว่า 0 เท่านั้น', $outputs->errorMessage);
    }

    function testWithdrawInputIsNotPositiveInteger2() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('0');
        $this->assertEquals('จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขจำนวนเต็มที่มีค่ามากกว่า 0 เท่านั้น', $outputs->errorMessage);
    }

    function testWithdrawInputIsNotPositiveInteger3() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('7.25');
        $this->assertEquals('จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขจำนวนเต็มที่มีค่ามากกว่า 0 เท่านั้น', $outputs->errorMessage);
    }

    function testAccountNumberIsNotExistingInCUBank() {
        $this->expectException(AccountInformationException::class);
        $sut = new Withdrawal('1111111111');
        $outputs = $sut->withdraw('5000');
    }

    function testAccountBalanceIsNotEnoughForWithdrawal() {
        $sut = new Withdrawal('0123444667');
        $outputs = $sut->withdraw('2000001');
        $this->assertEquals('ยอดเงินในบัญชีไม่เพียงพอ', $outputs->errorMessage);
    }
}
