<?php

use PHPUnit\Framework\TestCase;
use Atm\ObjectResult;

final class ObjectResultTest extends TestCase {
    function testAssignValueToAccountNumber() {
        $result = new ObjectResult();
        $result->accountNumber = '1234567890';
        $this->assertEquals('1234567890', $result->accountNumber);
    }

    function testAssignValueToAccountName() {
        $result = new ObjectResult();
        $result->accountName = 'Kittisak Phetrungnapha';
        $this->assertEquals('Kittisak Phetrungnapha', $result->accountName);
    }

    function testAssignValueToAccountBalance() {
        $result = new ObjectResult();
        $result->accountBalance = 10000;
        $this->assertEquals(10000, $result->accountBalance);
    }

    function testAssignValueToSourceAccountNumber() {
        $result = new ObjectResult();
        $result->sourceAccountNumber = '1234567890';
        $this->assertEquals('1234567890', $result->sourceAccountNumber);
    }

    function testAssignValueToWaterCharge() {
        $result = new ObjectResult();
        $result->waterCharge = 100;
        $this->assertEquals(100, $result->waterCharge);
    }

    function testAssignValueToElectricCharge() {
        $result = new ObjectResult();
        $result->electricCharge = 1000;
        $this->assertEquals(1000, $result->electricCharge);
    }

    function testAssignValueToPhoneCharge() {
        $result = new ObjectResult();
        $result->phoneCharge = 500;
        $this->assertEquals(500, $result->phoneCharge);
    }

    function testAssignValueToErrorMessage() {
        $result = new ObjectResult();
        $result->errorMessage = 'Something went wrong with your laptop. Please buy a new one!';
        $this->assertEquals('Something went wrong with your laptop. Please buy a new one!', $result->errorMessage);
    }

    function testPropertyIsNull() {
        $result = new ObjectResult();
        $this->assertEquals(NULL, $result->accountNumber);
    }
}