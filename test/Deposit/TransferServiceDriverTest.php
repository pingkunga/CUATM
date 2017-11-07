<?php
    require_once("src/deposit/stub/WithdrawServiceStub.php");
    require_once("src/deposit/DepositServiceWithStub.php");
    require_once("src/serviceauthentication/DBConnection.php");
    require_once("src/deposit/driver/TransferServiceDriver.php");
    //require_once("src/outputs/Outputs.php");

    use PHPUnit\Framework\TestCase;
    use Operation\DepositServiceWithStub;
    use Operation\TransferServiceDriver;
    use Operation\WithdrawServiceStub;

    class TransferServiceDriverTest extends TestCase {

        public function testCanPerformUnitTest(): void {
            $this->assertTrue(true);
        }  
        public static function setUpBeforeClass()
        {
            //Do Nothing เพราะไม่ได้ต่อ DB แล้ว
            //Ref: https://stackoverflow.com/questions/16657101/phpunit-cannot-send-session-cookie-headers-already-sent
            // $has_session = session_status() == PHP_SESSION_ACTIVE;
            // if($has_session) 
            // {
            //     session_start(); 
            // } 
            
        }
        public function testSimpleTransfer()
        {
            $transfer = new TransferServiceDriver('3430368497',WithdrawServiceStub::class,DepositServiceWithStub::class);

            $tOutput = $transfer->doTransfer('5971005021',5000);

            //ยอดเงินเดิมของ 3430368497(River Song) เดิม 10,000 บาท
            //โอนไปให้ 5971005021(Chatri Ngambenchawong) จำนวน 5,000 บาท
            //ยอดเงินของ 4235750021(Tony Stark) เหลือ 5,000 บาท
                
            $this->assertEquals(5000, $tOutput->accountBalance);
        }

        public static function tearDownAfterClass()
        {
            //Do Nothing เพราะไม่ได้ต่อ DB แล้ว
        }
    }
?>