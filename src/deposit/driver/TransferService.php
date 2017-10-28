<?php namespace Operation;

    require_once('src/deposit/DepositService.php');
    require_once(__DIR__.'../../stub/ServiceAuthenticationStub.php');
    
    use Output\Outputs;
    use Operation\DepositService;
    use Operation\ServiceAuthentication;

    class TransferService
    {
        public function transfer($sourceAccNo, $targetAccNo, $transferAmount): Outputs
        {
            $depositService = new DepositService($targetAccNo);
            
            $result = $depositService->deposit($transferAmount);
        
            return $result;
        }   
    }

?>