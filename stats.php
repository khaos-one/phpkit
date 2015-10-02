<?php

/**
 * Statistics module.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }
	
require_once('encoding.php');

class Stats {
	public static function Try_Extract_Search_Query($referrer) {
		static $query_pattern = '/(?:q|query|s|as_q|words|p|text|etext)=([%a-zA-Z0-9]+)/';
		$matches = array();
		if (preg_match($query_pattern, $referrer, $matches)) {
			return Encoding::Normalize(urldecode($matches[1]));
		}
		else {
			return null;
		}
	}
}
