<?php namespace Operation;

use Output\Outputs;

final class DepositStub {
    private $accNumber;
    
    public function __construct(string $accNumber){
        $this->accNumber = $accNumber;
    }

    public function deposit(int $amount): Outputs { 
        $mockAccNumber = "1234567890";
        $output = new Outputs();
        if($mockAccNumber == $this->accNumber) {
            $output->accNumber = $mockAccNumber;
        } else {
            $output->errorMessage = "ไม่พบหมายเลขบัญชีนี้ภายในระบบ CU Bank";
        }
        return $output;
    }
}