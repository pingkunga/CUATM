<?php

final class wDBConnectionStub {
    public static function saveTransaction(string $accNo, int $updatedBalance): bool {
        $result = array('accNo' => $accNo, 'updatedBalance' => $updatedBalance);
        return !empty($result);
    }
}