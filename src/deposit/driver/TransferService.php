<?php namespace CUATM;

    require_once('src/deposit/DepositService.php');
    require_once(__DIR__.'../../stub/ServiceAuthentication.php');
    
    use CUATM\DepositService;
    use CUATM\ServiceAuthentication;

    class TransferService
    {
        public function transfer($sourceAccNo, $targetAccNo, $transferAmount): ObjectResult
        {
            $serviceAuth = new ServiceAuthentication();
            $depositService = new DepositService();
            
            $result = $depositService->deposit($serviceAuth, $targetAccNo, $transferAmount);
        
            return $result;
        }   
    }

?>