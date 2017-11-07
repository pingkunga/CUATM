<?php namespace MainDriver;

use Operation\Transfer;
use Operation\Withdrawal;
use Operation\DepositService;

final class MainDriver {
    public function transfer(string $srcNumber,string $desNumber,int $amount): void {
        $transfer = new Transfer($srcNumber,Withdrawal::class,DepositService::class);
    	$transfer->doTransfer($desNumber,$amount);
    }
}