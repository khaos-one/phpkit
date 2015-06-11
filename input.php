<?php

/**
 * Module containing object for managing
 * script's input.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Input {
	private static $ip;
	public static function Is_Ajax_Request() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	public static function Post($varname) {
		return filter_input(INPUT_POST, $varname, FILTER_SANITIZE_STRING);
	}
	public static function Get($varname) {
		return filter_input(INPUT_GET, $varname, FILTER_SANITIZE_STRING);
	}
	public static function Method() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	public static function Is_Post() {
		return self::Method() === 'post';
	}
	public static function Is_Get() {
		return self::Method() === 'get';
	}
	public static function Is_Head() {
		return self::Method() === 'head';
	}
	public static function Ip() {
		if (isset(self::$ip)) {
			return self::$ip;
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			self::$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			self::$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			self::$ip = $_SERVER['REMOTE_ADDR'];
		}
		return self::$ip;
	}
}