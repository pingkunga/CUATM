# CUATM - กลุ่ม DEPOSIT
CUATM - Software Testing Project

# Install and Setup

1. Clone  Project ลงมา
2. CD เข้าไปที่ Folder ที่ Clone ลงมา
3. Install php lib dependency ด้วย composer install

# Testing การทดสอบ Driver & Stub

1.Driver คือ ตัวที่เอามาเรียก Code ที่ต้องการทดสอบ (Module(s) Under Test)
2.Stub คือ หนึ่งใน Test Double โดย Stub เป็น Code เขียนแทน Code ส่วนอื่นยังพัฒนาไม่เสร็จ แต่ส่วนที่ต้องการทดสอบ(Module(s) Under Test) ต้องใช้งาน

# Integation Test

Steps for Group Deposit I
1. Driver Main + Deposit + Stub Service Authen
>> ใช้คำสั่ง php -S localhost:8000 routerDriver.php เพื่อรัน builtin server
2. Driver Main + Deposit + Service Authen
>> ใช้คำสั่ง php -S localhost:8000 routerDriver.php เพื่อรัน builtin server
3. Main + Deposit + Service Authen
>> ใช้คำสั่ง php -S localhost:8000 router.php เพื่อรัน builtin server

Steps for Group Deposit II
1. Driver Transfer + Deposit + Stub Service Authen
>> ใช้คำสั่ง php -S localhost:8000 routerDriver.php เพื่อรัน builtin server
2. Driver Transfer + Deposit + Service Authen
>> ใช้คำสั่ง php -S localhost:8000 routerDriver.php เพื่อรัน builtin server
3. Transfer + Deposit + Service Authen
>> ใช้คำสั่ง php -S localhost:8000 router.php เพื่อรัน builtin server

