<?php
    //รับค่ามาจาก Request แบบ Post
    $accNo = $_POST['accNo'];
    $depositAmount = $_POST['depositAmount'];

    //สร้าง Service โดยส่งหมายเลขบัญชีไปเป็นข้อมูลนำเข้า
    $depositService = new DepositService($accNo);

    //เรียกใช้ Method deposit โดยส่งจำนวนเงินที่ต้องฝากเข้าไป
    $result = $depositService->deposit($depositAmount);

    //Do something
    //....
?>