<?php

    use PHPUnit\Framework\TestCase;
    use output\Outputs;

    class OutputsTest extends TestCase {
        public function testAssignValueToAccountNumber(): void {
            $result = new Outputs();
            $result->accountNumber = '5971005021';
            $this->assertEquals('5971005021', $result->accountNumber);
        }

        public function testAssignValueToAccountName(): void {
            $result = new Outputs();
            $result->accountName = 'Chatri Ngambenchawong';
            $this->assertEquals('Chatri Ngambenchawong', $result->accountName);
        }

        public function testAssignValueToAccountBalance(): void {
            $result = new Outputs();
            $result->accountBalance = 10000;
            $this->assertEquals(10000, $result->accountBalance);
        }

        public function testAssignValueToSourceAccountNumber(): void {
            $result = new Outputs();
            $result->sourceAccountNumber = '5971005021';
            $this->assertEquals('5971005021', $result->sourceAccountNumber);
        }

        public function testAssignValueToErrorMessage(): void {
            $result = new Outputs();
            $result->errorMessage = 'Cannot update new balance !!!';
            $this->assertEquals('Cannot update new balance !!!', $result->errorMessage);
        }

}