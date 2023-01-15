<?php 

namespace App\Classes;

use Exception;

class ErrorLog {

    public static function logInfo($log) {

        return file_put_contents(dirname(__DIR__) . '/Logs/error_log.txt', $log, FILE_APPEND) ??
            throw new Exception('Error log broken!');
    }
}