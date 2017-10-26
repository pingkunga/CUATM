<?php namespace CUATM;

class ObjectResult {

    public $accountNumber; // CHAR(10)
    public $accountName; // <= CHAR(50)
    public $accountBalance; // 0 and positive integer
    public $sourceAccountNumber; // For transfer domain, CHAR(10)
    public $waterCharge; // 0 and positive integer
    public $electricCharge; // 0 and positive integer
    public $phoneCharge; // 0 and positive integer
    public $errorMessage; // For failure case, String 
	
}