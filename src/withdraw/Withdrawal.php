<?php namespace Operation;

use Exception;
use AccountInformationException;
use Output\Outputs;
use Operation\ServiceAuthenticationStub;
use ServiceAuthentication;
use DBConnection;

require_once __DIR__.'./../outputs/Outputs.php';
require_once 'ServiceAuthenticationStub.php';
require_once __DIR__.'./../serviceauthentication/serviceauthentication.php';
//require_once 'DBConnectionStub.php';

final class Withdrawal {
    // instance variables
    private $accountNumber;
    private $accountName;
    private $accountBalance;
    private $maximumWithdraw = 100000;

    // constructors
    function __construct(string $accountNumber) {
        $this->accountNumber = $accountNumber;
    }

    // getter
    function getAccountNumber(): string {
        return $this->accountNumber;
    }

    function getAccountName(): string {
        return $this->accountName;
    }

    function getAccountBalance(): int {
        return $this->accountBalance;
    }

    // setter
    function setAccountBalance(int $accountBalance) {
        $this->accountBalance = $accountBalance;
    }

    // public
    function withdraw(string $inputFromUser): Outputs {
        $outputs = new Outputs();

        if ($this->checkWithdrawalInputIsNumber($inputFromUser)) {
            $number = floatval($inputFromUser);
            if ($this->checkWithdrawalNumberIsPositiveInteger($number)) {

                if ($number <= $this->maximumWithdraw) {
                    try 
                    {
                        $result = ServiceAuthentication::accountAuthenticationProvider($this->accountNumber);
                        $this->accountName = $result['accName'];
                        $this->accountBalance = $result['accBalance'];
    
                        $positiveInt = intval($number);
                        if ($this->checkAccountBalanceIsEnoughForWithdrawal($positiveInt, $this->accountBalance)) {
    
                            // withdraw successfully
                            if (DBConnection::saveTransaction($this->accountNumber, ($this->accountBalance - $positiveInt))) {
                                $outputs->accountNumber = $this->accountNumber;
                                $outputs->accountName = $this->accountName;
                                $this->accountBalance -= $positiveInt;
                                $outputs->accountBalance = $this->accountBalance;
                            } else {
                                $outputs->errorMessage = 'ระบบขัดข้อง ไม่สามารถถอนเงินได้ กรุณาลองใหม่อีกครั้งในภายหลัง';
                            }
    
                        } else {
                            $outputs->errorMessage = 'ยอดเงินในบัญชีไม่เพียงพอ';
                        }
                    } 
                    catch(AccountInformationException $e) 
                    {
                        $outputs->errorMessage = $e->getMessage();
                    }
                } else {
                    $outputs->errorMessage = 'จำนวนเงินถอนในแต่ละครั้งต้องไม่เกิน 100,000 บาท';
                }

            } else {
                $outputs->errorMessage = 'จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขจำนวนเต็มที่มีค่ามากกว่า 0 เท่านั้น';
            }

        } else {
            $outputs->errorMessage = 'จำนวนเงินที่ต้องการถอนต้องเป็นตัวเลขเท่านั้น';
        }

        return $outputs;
    }

    // private

    private function checkWithdrawalInputIsNumber(string $input): bool {
        return is_numeric($input);
    }

    private function checkWithdrawalNumberIsPositiveInteger(float $input): bool {
        if (is_int($input) || $input == intval($input)) {
            return intval($input) > 0;
        } else {
            return false;
        }
    }

    private function checkAccountBalanceIsEnoughForWithdrawal(int $totalWithdrawal, int $accountBalance): bool {
        return $totalWithdrawal <= $accountBalance;
    }
}
