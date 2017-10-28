<?php namespace Operation;
    //require_once "helper/MySQL.php";
    //include dirname(__FILE__).'/../../helper/MySQL.php';
    require_once(__DIR__.'../../database/MySQL.php');
    require_once('stub/ServiceAuthentication.php');
    require_once(__DIR__.'../../outputs/Outputs.php');
    
    use Database\MySQL;
    use Output\Outputs;
    use ServiceAuthentication;
    use Exception;

    class DepositService{
        public function deposit($accNo, $depositAmount): Outputs
        {
            $canDeposit = true;
            $result = new Outputs();
        
            #บริการฝากเงินเข้าบัญชีโดยต้องตรวจสอบหมายเลขบัญชีและจำนวนเงินฝาก คือ
            if(!is_numeric($depositAmount)) 
            {
                # 1. จำนวนเงินฝากต้องเป็นตัวเลขเท่านั้น
                $result->errorMessage = 'Deposit amount must be numeric';
                $canDeposit = false;
            } 
            else if ($depositAmount <= 0)
            {
                # 2. จำนวนเงินฝากต้อง > 0
                $result->errorMessage = 'Deposit amount must greater than zero';
                $canDeposit = false;
            }
            
            # 3. หมายเลขบัญชีมีในฐานข้อมูลระบบหรือไม่ผ่านบริการServiceAuthentication + ดึงยอดล่าสุด
            $serviceAuth = new ServiceAuthentication();
            $seviceAuthData = $serviceAuth->accountAuthenticationProvider($accNo);
            /*
            var_dump($seviceAuthData);
            var_dump(count($seviceAuthData));
            var_dump($seviceAuthData['accountNum']== $accountNum);
            */
            if($seviceAuthData['accNo']!= $accNo)
            {
                $result->errorMessage = 'Error account number not found';
                $canDeposit = false;
            }

            if ($canDeposit)
            {
                # 4. ปรับปรุงยอด
                $result->accountNumber = $seviceAuthData['accNo'];
                $result->accountName = $seviceAuthData['accName'];
                $result->accountBalance = $seviceAuthData['accBalance'] + $depositAmount;
                $result->errorMessage = 'Deposit Success';
                
                # 5. เรียก Method setBalance เพื่ออัพเดท ข้อมูลเงินฝากล่าสุด ?
                try
                {
                    $this->setNewBalance($result);
                }
                catch(Exception $e) 
                {
                    $result->errorMessage = 'Cannot update new balance';
                }
            }
            # 6. Return ผลลัพธ์
            return $result;
        }

        
        private function setNewBalance(Outputs $result)
        {
            //http://php.net/manual/en/mysqli.real-escape-string.php
            //UPDATE ACCOUNT SET BALANCE = 5000 WHERE NO = '5971005021'
            //Do some business logic
            $mysql = new MySQL();
            $sql = " UPDATE account SET balance = ".$mysql->escapeString($result->accountBalance);
            $sql = $sql." WHERE no = '".$mysql->escapeString($result->accountNumber)."'";

            //Execute Query
            $result = $mysql->execute($sql); 

            if ($result['isError'])
            {
                throw new Exception($result['description']);
            }
        }
    }

?>