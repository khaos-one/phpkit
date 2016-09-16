<?php

/**
 * String helper module.
 * 
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

require_once('array_helper.php');

class String_Helper {
    public static function Split_Trim(string $str, string $delimeter, string $trim_chars = " \t\n\r\0\x0B") : array {
        $trimmed = trim($str, $trim_chars);
        $split = explode($delimeter, $trimmed);
        return Array_Helper::Trim($split);
    }
}
 