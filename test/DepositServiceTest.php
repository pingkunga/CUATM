<?php
    require_once "src/deposit/DepositService.php";
    use PHPUnit\Framework\TestCase;
    use CUATM\DepositService;

    class DepositServiceTest extends TestCase {
        //ทุก Method ต้องขึ้นต้นด้วยคำว่า Test
        public function testCanPerformUnitTest(): void {
            $this->assertTrue(true);
        }  

        public function testSimpleDeposit(): void {
            //Given something
            //$deposit = new DepositService();

            //>> Configure the stub.
            $seviceAuthData = array('accountNum' => '1212312121'
                                   ,'accountName' => 'PingkungA'
                                   ,'currentBalance' => 0);
            /*
             * ใช้ Code นี้กรณีที่พี่ TA ให้ Class ServiceAuthentication มาแล้ว
            $stub = $this->createMock(\ServiceAuthentication::class);
            $stub->method('Authorize')
                 ->willReturn($seviceAuthData);
             */

            //ตอนนีมโนไปก่อน
            //$this->getMockBuilder('NameOfClass')->setMethods(array('foo'))->getMock();
            //Ref: https://stackoverflow.com/questions/28125444/phpunit-mock-non-existing-classes
            //$stub = $this->getMockBuilder('ServiceAuthentication')
            $stub = $this->getMockBuilder('CUATM\ServiceAuthentication')
                         ->setMethods(array('Authorize'))
                         ->getMock();

            $stub->method('Authorize')
                 ->with('1212312121')
                 ->will($this->returnValue($seviceAuthData));
            //>> stub บาง Function ของ Class DepositService ได้แก่ function setNewBalance 
            //>> เพื่อตัดปัญหาเรื่อง Database ออกไป
            //>> https://stackoverflow.com/questions/1164192/equivalent-of-simpletest-partial-mocks-in-phpunit
            $deposit = $this->getMockBuilder(DepositService::class)
                            ->setMethods(array('setNewBalance'))
                            ->getMock();
                            
            $deposit->method('setNewBalance')
                    ->with('1212312121', 500)
                    ->will($this->returnValue(true));
            //When
            $depositResult = $deposit->deposit($stub, '1212312121', 500);
    
            //Then
            //$this->assertEquals(count($stub->Authorize('1212312121')), 3);
            //$this->assertEquals($stub->Authorize('1212312121')['accountName'], 'PingkungA');
            //$this->assertEquals(500, $depositResult['currentBalance']);4
            $this->assertEquals(500,  $depositResult->accountBalance);
        }
        
        
        public function testDepositWhenDepositAmountIsNotNumberic(): void {
            //GIVEN
            $seviceAuthData = array('accountNum' => '1212312121'
                                   ,'accountName' => 'PingkungA'
                                   ,'currentBalance' => 700);

            //Ref: https://stackoverflow.com/questions/28125444/phpunit-mock-non-existing-classes
            $stub = $this->getMockBuilder('CUATM\ServiceAuthentication')
                         ->setMethods(array('Authorize'))
                         ->getMock();

            $stub->method('Authorize')
                 ->with('1212312121')
                 ->will($this->returnValue($seviceAuthData));

            //>> stub บาง Function ของ Class DepositService ได้แก่ function setNewBalance 
            //>> เพื่อตัดปัญหาเรื่อง Database ออกไป
            //>> https://stackoverflow.com/questions/1164192/equivalent-of-simpletest-partial-mocks-in-phpunit
            $deposit = $this->getMockBuilder(DepositService::class)
                            ->setMethods(array('setNewBalance'))
                            ->getMock();

            $deposit->method('setNewBalance')
                    ->with('1212312121', 700)
                    ->will($this->returnValue(true));

            //WHEN
            $depositResult = $deposit->deposit($stub, '1212312121', 'สองร้อยบาท');

            //THEN
            $this->assertEquals('Deposit amount must be numeric', $depositResult->errorMessage);
        }

        public function testDepositWhenDepositAmountIsLessThanZero(): void {
            //GIVEN
            $seviceAuthData = array('accountNum' => '1212312121'
                                   ,'accountName' => 'PingkungA'
                                   ,'currentBalance' => 700);

            //Ref: https://stackoverflow.com/questions/28125444/phpunit-mock-non-existing-classes
            $stub = $this->getMockBuilder('CUATM\ServiceAuthentication')
                         ->setMethods(array('Authorize'))
                         ->getMock();

            $stub->method('Authorize')
                 ->with('1212312121')
                 ->will($this->returnValue($seviceAuthData));

            //>> stub บาง Function ของ Class DepositService ได้แก่ function setNewBalance 
            //>> เพื่อตัดปัญหาเรื่อง Database ออกไป
            //>> https://stackoverflow.com/questions/1164192/equivalent-of-simpletest-partial-mocks-in-phpunit
            $deposit = $this->getMockBuilder(DepositService::class)
                            ->setMethods(array('setNewBalance'))
                            ->getMock();

            $deposit->method('setNewBalance')
                    ->with('1212312121', 700)
                    ->will($this->returnValue(true));

            //WHEN
            $depositResult = $deposit->deposit($stub, '1212312121', -1);

            //THEN
            $this->assertEquals('Deposit amount must greater than zero', $depositResult->errorMessage);
        }
        
        public function testDepositWhenDepositAmountIsZero(): void {
            //GIVEN
            $seviceAuthData = array('accountNum' => '1212312121'
                                   ,'accountName' => 'PingkungA'
                                   ,'currentBalance' => 700);

            //Ref: https://stackoverflow.com/questions/28125444/phpunit-mock-non-existing-classes
            $stub = $this->getMockBuilder('CUATM\ServiceAuthentication')
                         ->setMethods(array('Authorize'))
                         ->getMock();

            $stub->method('Authorize')
                 ->with('1212312121')
                 ->will($this->returnValue($seviceAuthData));

            //>> stub บาง Function ของ Class DepositService ได้แก่ function setNewBalance 
            //>> เพื่อตัดปัญหาเรื่อง Database ออกไป
            //>> https://stackoverflow.com/questions/1164192/equivalent-of-simpletest-partial-mocks-in-phpunit
            $deposit = $this->getMockBuilder(DepositService::class)
                            ->setMethods(array('setNewBalance'))
                            ->getMock();

            $deposit->method('setNewBalance')
                    ->with('1212312121', 700)
                    ->will($this->returnValue(true));

            //WHEN
            $depositResult = $deposit->deposit($stub, '1212312121', 0);

            //THEN
            $this->assertEquals('Deposit amount must greater than zero', $depositResult->errorMessage);
        }


        //https://stackoverflow.com/questions/277914/how-can-i-get-phpunit-mockobjects-to-return-different-values-based-on-a-paramete
        /*
        public function testCallback()
        {
            $result = array('path' => array()
                           ,'accountNum' => $accountNum 
                           ,'accountName' => $accountName
                           ,'currentBalance' => 0
                           ,'message' => 'Deposit Success');
        }
        */
      
    }
?>