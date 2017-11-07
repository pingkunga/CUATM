<?php namespace Operation;


require_once "outputs/Outputs.php";
use Output\Outputs;
use DBConnection;
use AccountInformationException;
use BillingException;
use ServiceAuthentication;

class BillPayment{
    private $acctNum;

    public function __construct(string $acctNum){
        $this->acctNum = $acctNum;
    }

    public function pay(int $billType){
      $output = new Outputs();
      try{
        if ($billType >= 0 && $billType <= 2){
          $billOutput = $this->getBill($billType);
          $chargeAmount = $billOutput->billAmount;
          if($chargeAmount == 0){
            $output->errorMessage = "คุณไม่มียอดค้างชำระสำหรับบิลนี้แล้ว";
          }
          elseif($chargeAmount < 0){
            $output->errorMessage = "พบข้อผิดพลาดบนฐานข้อมูล โปรดติดต่อผู้ดูแลระบบ";
          }
          else{
            $acctInfo = ServiceAuthentication::accountAuthenticationProvider($this->acctNum);
            $newBalance = $acctInfo["accBalance"]-$chargeAmount;
            if($newBalance >= 0){
              DBConnection::saveTransaction($this->acctNum,$newBalance);
              DBConnection::clearCharge($this->acctNum,$billType);

              $output->accountNumber = $this->acctNum;
              $output->accountName = $acctInfo["accName"];
              $output->accountBalance = $newBalance;
            }
            else{
              $output->errorMessage = "ขออภัย, เงินในบัญชีของคุณไม่พอ";
            }
          }

        }
        else{
          $output->errorMessage = "ไม่มีรายการชำระเงินดังกล่าวในระบบ!";
        }
      }
      catch(AccountInformationException $e){
        $output->errMessage = $e->getMessage();
      }
      catch(BillingException $e){
        $output->errMessage = $e->getMessage();
      }

      return $output;
    }
    public function getBill(int $billType){
      $output = new Outputs();
      if ($billType >= 0 && $billType <= 2){
        try{
          $output->billAmount = DBConnection::getCharge($this->acctNum,$billType);
        }
        catch(AccountInformationException $e){
          $output->errMessage = $e->getMessage();
        }
        catch(BillingException $e){
          $output->errMessage = $e->getMessage();
        }
        return $output;
      }
      else{
        $output->errorMessage = "ไม่มีรายการชำระเงินดังกล่าวในระบบ!";
      }
    }
}
