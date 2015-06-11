<?php

/**
 * Structure for managing complex function outputs
 * with errors.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Error_Result {
    private $errors = array();
    private $errors_data = array();

    public function __construct($code = '', $message = '', $data = '') {
        if (empty($code)) {
            return;
        }
        $this->errors[$code][] = $message;
        if (!empty($data)) {
            $this->errors_data[$code] = $data;
        }
    }
    public function Error_Codes() {
        return array_keys($this->errors);
    }
    public function Error_Code() {
        $codes = $this->Error_Codes();
        if (empty($codes)) {
            return '';
        }
        return $codes[0];
    }
    public function Error_Message() {
        $code = $this->Error_Code();
        if (empty($code)) {
            return '';
        }
        if (empty($this->errors[$code])) {
            return '';
        }
        return $this->errors[$code][0];
    }
    public function Data($code) {
        if (empty($this->errors_data[$code])) {
            return '';
        }
        return $this->errors_data[$code];
    }
    public function Add($code, $message = '', $data = '') {
        $this->errors[$code][] = $message;
        if (!empty($data)) {
            $this->errors_data[$code] = $data;
        }
    }
    public function Remove($code) {
        unset($this->errors[$code]);
        unset($this->errors_data[$code]);
    }
}

function Is_Error($var) {
    return ($var instanceof Error_Result);
}