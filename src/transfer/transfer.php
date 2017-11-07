<?php namespace Operation;

use Output\Outputs;

require_once __DIR__.'./../outputs/Outputs.php';

class Transfer{
    private $srcNumber,$withdrawal,$deposit;
    
        public function __construct(string $srcNumber,$withdrawal,$deposit){
            $this->srcNumber = $srcNumber;
            $this->withdrawal = new $withdrawal($srcNumber);
            $this->deposit = $deposit;
        }
    
        public function doTransfer(string $desNumber,int $amount): Outputs {
            $output = new Outputs();
    
            if($this->srcNumber == $desNumber) {
                $output->errorMessage = "บัญชีที่เลือกไม่สามารถเป็นบัญชีรับโอนได้";
            } else {
                $wOutput = $this->withdrawal->withdraw($amount);
                if($wOutput->errorMessage == null) {
                    $output->accountBalance = $wOutput->accountBalance;
                    
                    $this->deposit = new $this->deposit($desNumber);
                    $dOutput = $this->deposit->deposit($amount);
                    if($dOutput->errorMessage != null) {
                        $output->errorMessage = $dOutput->errorMessage;
                    }
                } else {
                    $output->errorMessage = $wOutput->errorMessage;
                }
            }
            return $output;
        }

        public function setWithdrawal($withdrawal) {
            $this->withdrawal = new $withdrawal($this->srcNumber);
        }

        public function setDeposit($deposit) {
            $this->deposit = $deposit;
        }
}
