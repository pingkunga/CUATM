<?php namespace Operation;

require_once __DIR__.'./../serviceauthentication/AccountInformationException.php';

use AccountInformationException;

final class ServiceAuthenticationStub {
    static function accountAuthenticationProvider(string $accNo): array {
        if ($accNo !== '0123444667') {
            throw new AccountInformationException("Account number : {$accNo} not found.");
        } 

        return array('accNo' => '0123444667', 'accName' => 'Kritsada Kancha', 'accBalance' => 2000000);
    } 
}