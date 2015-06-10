<?php
	
/** Class for managing script's input. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Input {
	public static function Is_Ajax_Request() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	public static function Post($varname) {
		return filter_input(INPUT_POST, $varname, FILTER_SANITIZE_STRING);
	}
}