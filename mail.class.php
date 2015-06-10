<?php
	
/** Class for managing mail sending. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Mail {
	public $To;
	public $From;
	public $Subject;
	public $Headers;
	public $Content;
	
	public function __construct() {
		$this->Headers = array();
	}
	
	public function Send() {
		$headers = '';
		foreach ($this->Headers as $k => $v) {
			$headers .= $k . ': ' . $v . "\r\n";
		}
		if (is_array($this->To)) {
			$this->To = implode(',', $this->To);
		}
		return mail($this->To, $this->Subject, $this->Content, $headers);
	}
}