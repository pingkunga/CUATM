<?php 

    class ServiceAuthentication
    {
        public function accountAuthenticationProvider(string $accNo) : array
        {
            if ($accNo == '1212312121')
            {
                return array('accNo' => '1212312121'
                            ,'accName' => 'PingkungA'
                            ,'accBalance' => 0);
            }
            else if ($accNo == '5971005021')
            {
                return array('accNo' => '5971005021'
                            ,'accName' => 'PingkungA'
                            ,'accBalance' => 5000);
            }
            
            return array();
        }
    }
?>