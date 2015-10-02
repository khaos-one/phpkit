<?php

/**
 * Class for work with encodings.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }
	
class Encoding {
	public static function Normalize($text, $target_enc = 'utf-8', $source_enc = null) {
		if (function_exists('mb_convert_encoding')) {
			if (!$source_enc) {
				$source_enc = mb_detect_encoding($text);
			}
			return mb_convert_encoding($text, $target_enc, $source_enc);
		}
		
		return $text;
	}
}
