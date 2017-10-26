<?php namespace CUATM;

    require_once('src/deposit/DepositService.php');
    require_once(__DIR__.'../../stub/ServiceAuthentication.php');
    
    use CUATM\DepositService;
    use CUATM\ServiceAuthentication;

    //ดึงค่าออกมา
    $service = $_POST["service"];
    $session = isset($_COOKIE["authentication"])?$_COOKIE["authentication"]:null;

    try{
        if ($service == "Authentication"){
          $transaction = $_POST["transaction"];
          $auth = new Authentication($transaction["acct_num"],$transaction["pin"]);
          echo json_encode($auth->login());
        }
        elseif($session)
        {
            if ($service == "CustBalanceInq")
            {
                //Do nothing
            }
            elseif ($service == "Deposit")
            {
                /*
                $transaction = $_POST["transaction"];
                $deposit = new Deposit($session);
                echo json_encode($deposit->deposit($transaction["amt"]));
                */
                //จริงๆ อยากให้ Pass ServiceAuthentication เป็น Constucture นะ
                $serviceAuth = new ServiceAuthentication();
                $depositService = new DepositService();
            }
            elseif ($service == "Withdraw")
            {
              //Do nothing
            }
            elseif ($service == "Transfer")
            {
              //Do nothing
            }
            elseif ($service == "BillPayment")
            {
             //Do nothing
            }
            elseif ($service == "BillPaymentInq")
            {
                //Do nothing
            }
            elseif ($service == "ServiceAuthentication")
            {
                //Do nothing
            }
            else
            {
                http_response_code(501);
                echo json_encode();
            }
        }
        else
        {
            http_response_code(401);
            echo json_encode();
        }
       
      }catch(Error $e){
        http_response_code(400);
        echo json_encode();
      }
?> 