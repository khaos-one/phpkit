<?php

/**
 * Module for managing script's output.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Output {
	private static $instance = null;

	public static function Instance() {
		if (self::$instance === null) {
			self::$instance = new Output();
		}

		return self::$instance;
	}

	public static function Response_Code_And_Exit($response_code) {
		$out = self::Instance();
		$out->Response_Code($response_code);
		$out->End();
	}

	private $response_code;
	private $content;
	private $headers;
	
	public function __construct() {
		$this->headers = array();
	}
	
	public function Response_Code($code) {
		$this->response_code = $code;
	}
	
	public function Redirect($location) {
		$this->headers[] = 'Location: ' . $location;
	}
	
	public function Content($content) {
		$this->content = $content;
	}
	
	public function Json_Content(array $content) {
		$this->content = json_encode($content);
	}
	
	public function Flush() {
		if (isset($this->response_code)) {
			http_response_code($this->response_code);
		}
		foreach ($this->headers as $k => $v) {
			header("$k: $v");
		}
		echo $this->content;
	}
	
	public function End() {
		$this->Flush();
		exit();
	}
}