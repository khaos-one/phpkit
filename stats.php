<?php

/**
 * Statistics module.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

require_once('input.php');
require_once('encoding.php');
require_once('csv.php');

class Stats {
	public $datetime;
	public $ip;
	public $request_uri;
	public $user_agent;
	public $referrer;
	public $search_query;
	
	public function __construct() {
		$this->datetime = date('Y-m-d H:i:s');
		$this->ip = Input::Ip();
		$this->request_uri = Input::Request_Uri();
		$this->user_agent = Input::User_Agent();
		$this->referrer = Input::Referrer();
		$this->search_phrase = self::Try_Extract_Search_Query($referrer);
	}
	
	public static function Try_Extract_Search_Query($referrer) {
		static $query_pattern = '/(?:q|query|s|as_q|words|p|text|etext)=([%a-zA-Z0-9]+)/';
		if (!$referrer) {
			return null;
		}
		$matches = array();
		if (preg_match($query_pattern, $referrer, $matches)) {
			return Encoding::Normalize(urldecode($matches[1]));
		}
		else {
			return null;
		}
	}
	
	public function To_Csv_File($filepath) {
		$csv = new CSV();
		$csv->header = array('Date Time', 'IP', 'Request URI', 'Referrer', 'Search Phrase', 'User Agent');
		$csv->Add(array($this->datetime, $this->ip, $this->request_uri, $this->referrer, $this->search_phrase, $this->user_agent));
		$csv->To_File($filepath);
	}
}
