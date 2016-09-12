<?php

/**
 * Module for managing email sending.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Mail {
	public $To;
	public $From;
	public $Subject;
	public $Headers;
	public $Content;
	public $Error;
	
	public function __construct() {
		$this->Headers = array();
		$this->Error = null;
	}

	public function Has_Error() {
		return !empty($this->Error);
	}
	
	public function Send() {
		if (!empty($this->From)) {
			$this->Headers['From'] = $this->From;
		}
		
		$headers = '';
		
		foreach ($this->Headers as $k => $v) {
			$headers .= $k . ': ' . $v . "\r\n";
		}
		
		if (is_array($this->To)) {
			$this->To = implode(',', $this->To);
		}
		
		if (mail($this->To, $this->Subject, $this->Content, $headers) === false) {
			$this->Error = error_get_last();
			return false;
		}
		else {
			return true;
		}
	}
}