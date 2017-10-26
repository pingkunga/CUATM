<?php
    //require_once "../vendor/autoload.php";
    require_once(__DIR__.'/../../vendor/autoload.php');
    require_once('stub/ServiceAuthentication.php');
    use CUATM\DepositService;
    use CUATM\ServiceAuthentication;

    $accountNo = $_POST['accountNo'];
    $depositAmount = $_POST['depositAmount'];

    //var_dump($depositAmount);
    //สร้าง Stub ServiceAuthen
    $serviceAuth = new ServiceAuthentication();
    $depositService = new DepositService();
    
    $result = $depositService->deposit($serviceAuth, $accountNo, $depositAmount);
    //ต้อง Echo นะไม่งั้น Ajax ยังไม่รู้
    echo json_encode($result);
?>