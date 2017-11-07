<?php
    //require_once "../vendor/autoload.php";
    require_once(__DIR__.'/../../vendor/autoload.php');
    require_once('stub/ServiceAuthenticationStub.php');
    require_once("DepositService.php");

    use PHPUnit\Framework\TestCase;
    use Operation\DepositService;

    $accNo = $_POST['accNo'];
    $depositAmount = $_POST['depositAmount'];

    //var_dump($depositAmount);
    $depositService = new DepositService($accNo);
    
    $result = $depositService->deposit($depositAmount);
    //ต้อง Echo นะไม่งั้น Ajax ยังไม่รู้
    echo json_encode($result);
?>