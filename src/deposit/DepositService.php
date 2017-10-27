<?php namespace CUATM;
    //require_once "helper/MySQL.php";
    //include dirname(__FILE__).'/../../helper/MySQL.php';
    require_once(__DIR__.'../../database/MySQL.php');
    require_once('stub/ServiceAuthentication.php');
    require_once(__DIR__.'../../outputs/Outputs.php');
    
    use Database\MySQL;
    use Output\Outputs;
    use Exception;

    class DepositService{
        /*
        public function deposit(ServiceAuthentication $ServiceAuthentication, $accountNum, $depositAmount): array
        {
            $canDeposit = true;
            $result = array('path' => array()
                           ,'canDeposit' => false
                           ,'accountNum' => $accountNum 
                           ,'accountName' => 'Dummy'
                           ,'currentBalance' => 0
                           ,'message' => 'Deposit Success');

            #บริการฝากเงินเข้าบัญชีโดยต้องตรวจสอบหมายเลขบัญชีและจำนวนเงินฝาก คือ

            
            if(!is_numeric($depositAmount)) {
                # 1. จำนวนเงินฝากต้องเป็นตัวเลขเท่านั้น
                $result['message'] = 'Deposit amount must be numeric';
                $canDeposit = false;
            } 
            else if ($depositAmount <= 0)
            {
                # 2. จำนวนเงินฝากต้อง > 0
                $result['message'] = 'Deposit amount must greater than zero';
                $canDeposit = false;
            }
            
            # 3. หมายเลขบัญชีมีในฐานข้อมูลระบบหรือไม่ผ่านบริการServiceAuthentication + ดึงยอดล่าสุด
            $seviceAuthData = $ServiceAuthentication->Authorize($accountNum);

            var_dump($seviceAuthData);
            var_dump(count($seviceAuthData));
            var_dump($seviceAuthData['accountNum']== $accountNum);

            if($seviceAuthData['accountNum']!= $accountNum)
            {
                $result['message'] = 'Error account number not found';
                $canDeposit = false;
            }

            if ($canDeposit)
            {
                # 4. ปรับปรุงยอด
                $result['accountNum'] = $seviceAuthData['accountNum'];
                $result['accountName'] = $seviceAuthData['accountName'];
                $result['currentBalance'] = $seviceAuthData['currentBalance'] + $depositAmount;
                
                //var_dump($depositAmount);

                # 4. เรียก Method setBalance เพื่ออัพเดท ข้อมูลเงินฝากล่าสุด ?
                if($this->setNewBalance($result['accountNum'], $result['currentBalance']))
                {
                    $result['message'] = 'Cannot update new balance';
                }
                else
                {
                    $result['canDeposit'] = true;
                    $result['message'] = 'Deposit Success';
                }
            }
            # 5. Return ผลลัพธ์
            return $result;
        }

        
        protected function setNewBalance($accountNum, $newBalance)
        {
            //http://php.net/manual/en/mysqli.real-escape-string.php
            //UPDATE ACCOUNT SET BALANCE = 5000 WHERE NO = '5971005021'
            //Do some business logic
            $mysql = new MySQL();
            $sql = " UPDATE account SET balance = ".$mysql->escapeString($newBalance);
            $sql = $sql." WHERE no = '".$mysql->escapeString($accountNum)."'";

            //Execute Query
            $result = $mysql->execute($sql); 

            if (!$result['isError'])
            {
                return false;
            }
            else
            {
                return true;
            }

        }
        */

        public function deposit(ServiceAuthentication $ServiceAuthentication
                              , $accountNum
                              , $depositAmount): Outputs
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
            $seviceAuthData = $ServiceAuthentication->Authorize($accountNum);
            /*
            var_dump($seviceAuthData);
            var_dump(count($seviceAuthData));
            var_dump($seviceAuthData['accountNum']== $accountNum);
            */
            if($seviceAuthData['accountNum']!= $accountNum)
            {
                $result->errorMessage = 'Error account number not found';
                $canDeposit = false;
            }

            if ($canDeposit)
            {
                # 4. ปรับปรุงยอด
                $result->accountNumber = $seviceAuthData['accountNum'];
                $result->accountName = $seviceAuthData['accountName'];
                $result->accountBalance = $seviceAuthData['currentBalance'] + $depositAmount;
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