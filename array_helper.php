<?php

/**
 * Array helper module.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Array_Helper {
    public static function Trim(array &$arr) : array {
        return array_filter($arr, function ($item) {
            return !empty($item);
        });
    }
}
