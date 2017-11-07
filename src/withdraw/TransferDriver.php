<?php namespace Operation;

use Operation\Withdrawal;
use Output\Outputs;

require_once __DIR__.'./../outputs/Outputs.php';
require_once 'Withdrawal.php';

final class TransferDriver {
    private $accountNumber;
    
    function __construct(string $accountNumber) {
        $this->accountNumber = $accountNumber;
    }
    
    public function transfer(string $transferMoney, string $destinationAccount): Outputs {   
        $wAccount = new Withdrawal($this->accountNumber);
        $outputs = $wAccount->withdraw($transferMoney);
        return $outputs;
    }
}
