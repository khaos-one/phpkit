<?php

/**
 * Logging module.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Log {
    const EMERGENCY = 0;
    const ALERT = 1;
    const CRITICAL = 2;
    const ERROR = 3;
    const WARNING = 4;
    const NOTICE = 5;
    const INFO = 6;
    const DEBUG = 7;

    private static $priorities = array (
        self::EMERGENCY => 'emergency',
        self::ALERT => 'alert',
        self::CRITICAL => 'critical',
        self::ERROR => 'error',
        self::WARNING => 'warning',
        self::NOTICE => 'notice',
        self::INFO => 'info',
        self::DEBUG => 'debug'
    );

    public static function Entry_Message(int $priority, string $message, $output_code = -1) {
        $args = array_slice(func_get_arg(), 2);
        $entry = vsprintf(self::priorities[$priority] . ': ' . $message, $args);
        error_log($entry);
    }

    public static function Entry_Exception(int $priority, Exception $e) {
        $entry = sprintf('%s: %s', self::priorities[$priority], $e->getMessage());
        error_log($entry);
    }
}
