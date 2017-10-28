<?php
    require_once "src/deposit/driver/TransferService.php";
    use PHPUnit\Framework\TestCase;
    use Operation\TransferService;

    class TransferServiceDriverTest extends TestCase {
        public function testCanPerformUnitTest(): void {
            $this->assertTrue(true);
        }  

        public function testSimpleTransfer()
        {

            //Given something
            /*
            $deposit = $this->getMockBuilder(DepositService::class)
                            ->setMethods(array('setNewBalance'))
                            ->getMock();
            
            $deposit->method('setNewBalance')
                    ->with('1212312121', 500)
                    ->will($this->returnValue(true));
            //When
            */
            //$depositResult = $deposit->deposit(, '1212312121', 500);

            $transferService = new TransferService();

            $objectResult = $transferService->transfer('1212312120', '1212312121', 500);

            //Then
            $this->assertEquals(500,  $objectResult->accountBalance);
        }
    }
?>