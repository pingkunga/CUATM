<?php namespace Operation;

use Operation\Withdrawal;
use Output\Outputs;

require_once __DIR__.'./../outputs/Outputs.php';
require_once 'Withdrawal.php';

final class MainDriver {
    public function withdraw(string $accountNumber, string $withdrawMoney): Outputs { 
        $wAccount = new Withdrawal($accountNumber);
        $output = $wAccount->withdraw($withdrawMoney);
        return $output;
    }
}
