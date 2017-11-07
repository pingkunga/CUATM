<?php namespace Operation;

require_once "outputs/Outputs.php";
use Output\Outputs;

class BillPayment{
    private $acctNum;

    public function __construct(string $acctNum){
        $this->acctNum = $acctNum;
    }

    public function pay(int $billType){
      $output = new Outputs();
      if ($billType >= 0 && $billType <= 2){
        if ($billType == 0){
          $output->errorMessage = "ขออภัย, เงินในบัญชีของคุณไม่พอ";
        }
        else{
          $output->accountNumber = $this->acctNum;
          $output->accountName = "Mr. Example";
          $output->accountBalance = 200;
        }
      }
      else{
        $output->errorMessage = "ไม่มีรายการชำระเงินดังกล่าวในระบบ!";
      }
      return $output;
    }
    public function getBill(int $billType){
      $output = new Outputs();
      if ($billType >= 0 && $billType <= 2){
        if($billType == 0){
          $output->billAmount = 1500;
        }
        elseif($billType == 1){
          $output->billAmount = 200;
        }
        else{
          $output->billAmount = 599;
        }
        return $output;
      }
      else{
        $output->errorMessage = "ไม่มีรายการชำระเงินดังกล่าวในระบบ!";
      }
    }
}
