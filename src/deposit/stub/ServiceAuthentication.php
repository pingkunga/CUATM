<?php namespace CUATM;

    class ServiceAuthentication
    {
        public function Authorize($accountNum) : array
        {
            if ($accountNum == '1212312121')
            {
                return array('accountNum' => '1212312121'
                ,'accountName' => 'PingkungA'
                ,'currentBalance' => 0);
            }
            else if ($accountNum == '5971005021')
            {
                return array('accountNum' => '5971005021'
                ,'accountName' => 'PingkungA'
                ,'currentBalance' => 5000);
            }
            
            return array();
        }
    }
?>