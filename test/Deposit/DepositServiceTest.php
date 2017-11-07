<?php
    require_once("src/deposit/DepositService.php");
    require_once("src/serviceauthentication/DBConnection.php");

    use PHPUnit\Framework\TestCase;
    use Operation\DepositService;
    

    class DepositServiceTest extends TestCase {
        
        /*
         *  ASSUMPTION
         *  >> หลังจากหาข้อมูลจากหลายๆ ธนาคารพบว่า สามารถฝากเงินได้สูงสุด 100,000 บาท 
         *  >> ธนบัตร 100 บาท แต่ละใบ มูลค่าสูงสุด 1,000 บาทห
         *
         */
        protected function setUp()
        {
            //Note: Run ก่อน Execute แต่ละ Test Case
        }
 
        public static function setUpBeforeClass()
        {
            DBConnection::restore();
        }

        public function testCanPerformUnitTest(): void {
            $this->assertTrue(true);
        }  

        public function testDepositWhenUserNotFound(): void {
            //GIVEN
            $depositService = new DepositService('987654321');
             
            //WHEN
            $depositResult = $depositService->deposit(100);
             
            //THEN
            $this->assertEquals("Account number : 987654321 not found.",  $depositResult->errorMessage);
        }

        public function testSimpleDeposit(): void {
            //Given something
            //$deposit = new DepositService();

            //>> Configure the stub.
            // $seviceAuthData = array('accountNum' => '1212312121'
            //                        ,'accountName' => 'PingkungA'
            //                        ,'currentBalance' => 0);
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
            // $stub = $this->getMockBuilder('CUATM\ServiceAuthentication')
            //              ->setMethods(array('Authorize'))
            //              ->getMock();

            // $stub->method('Authorize')
            //      ->with('1212312121')
            //      ->will($this->returnValue($seviceAuthData));
            //>> stub บาง Function ของ Class DepositService ได้แก่ function setNewBalance 
            //>> เพื่อตัดปัญหาเรื่อง Database ออกไป
            //>> https://stackoverflow.com/questions/1164192/equivalent-of-simpletest-partial-mocks-in-phpunit
            // $deposit = $this->getMockBuilder(DepositService::class)
            //                 ->setMethods(array('setNewBalance'))
            //                 ->getMock();
                            
            // $deposit->method('setNewBalance')
            //         ->with('1212312121', 500)
            //         ->will($this->returnValue(true));


            //GIVEN
            $depositService = new DepositService('5971005021');

            //WHEN
            $depositResult = $depositService->deposit(5500);
    
            //Then
            //$this->assertEquals(count($stub->Authorize('1212312121')), 3);
            //$this->assertEquals($stub->Authorize('1212312121')['accountName'], 'PingkungA');
            //$this->assertEquals(500, $depositResult['currentBalance']);4
            $this->assertEquals(10500,  $depositResult->accountBalance);
        }

        public function testDepositWhenDepositAmountIsInteger(): void {
            //GIVEN
            $depositService = new DepositService('2476492431');

            //WHEN
            $depositResult = $depositService->deposit(5000);

            //THEN
            $this->assertEquals(1005000, $depositResult->accountBalance);
        }

        public function testDepositWhenDepositAmountIsString(): void {
            //GIVEN
            $depositService = new DepositService('2476492431');

            //WHEN
            $depositResult = $depositService->deposit("ห้าพันบาท");

            //THEN
            $this->assertEquals("จำนวนเงินฝากต้องเป็นตัวเลขเท่านั้น", $depositResult->errorMessage);
        }

        public function testDepositWhenDepositAmountIsNotInteger(): void {
            //GIVEN
            $depositService = new DepositService('2476492431');

            //WHEN
            $depositResult = $depositService->deposit(50.25);

            //THEN
            $this->assertEquals("จำนวนเงินฝากต้องเป็นจำนวนเต็มเท่านั้น", $depositResult->errorMessage);
        }

        //MIN - 1
        public function testDepositWhenDepositAmountIsLessThanZero(): void {
            //GIVEN
            $depositService = new DepositService('0123444667');

            //WHEN
            $depositResult = $depositService->deposit(-1);

            //THEN
            $this->assertEquals('จำนวนเงินฝากต้องมากกว่า 0 บาท', $depositResult->errorMessage);
        }
        
        //MIN
        public function testDepositWhenDepositAmountIsZero(): void {
            //GIVEN
            $depositService = new DepositService('0123444667');

            //WHEN
            $depositResult = $depositService->deposit(0);

            //THEN
            $this->assertEquals('จำนวนเงินฝากต้องมากกว่า 0 บาท', $depositResult->errorMessage);
        }

        //MIN + 1
        public function testDepositWhenDepositAmountIsOne(): void {
            //GIVEN
            $depositService = new DepositService('1924356780');

            //WHEN
            $depositResult = $depositService->deposit(1);

            //THEN
            $this->assertEquals(890201,  $depositResult->accountBalance);
        }

        //NORM
        public function testDepositWhenDepositNorm(): void {
            //GIVEN
            $depositService = new DepositService('4235750021');

            //WHEN
            $depositResult = $depositService->deposit(50000);

            //THEN
            $this->assertEquals(4050000,  $depositResult->accountBalance);
        }

        //MAX - 1
        public function testDepositWhenDepositMaxMinusOne(): void {
            //GIVEN
            $depositService = new DepositService('7840125312');

            //WHEN
            $depositResult = $depositService->deposit(99999);

            //THEN
            $this->assertEquals(150000,  $depositResult->accountBalance);
        }

        //MAX
        public function testDepositWhenDepositMax(): void {
            //GIVEN
            $depositService = new DepositService('5902150431');

            //WHEN
            $depositResult = $depositService->deposit(100000);

            //THEN
            $this->assertEquals(9655000,  $depositResult->accountBalance);
        }

        //MAX+1
        public function testDepositWhenDepositMaxPlus1(): void {
            //GIVEN
            $depositService = new DepositService('9835602413');

            //WHEN
            $depositResult = $depositService->deposit(100001);

            //THEN
            $this->assertEquals("จำนวนเงินฝากในแต่ละครั้งต้องไม่เกิน 100,000 บาท",  $depositResult->errorMessage);
        }

        public static function tearDownAfterClass()
        {
            DBConnection::restore();
        }
        protected function tearDown()
        {
            //Note: Run หลัง Execute แต่ละ Test Case
        }
    }
?>