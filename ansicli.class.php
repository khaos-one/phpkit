<?php
	
/** Class for outputting to ANSI terminals. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Ansi_Color {
	const FORE_BLACK 		= '0;30';
	const FORE_DARK_GRAY 	= '1;30';
	const FORE_BLUE 		= '0;34';
	const FORE_LIGHT_BLUE 	= '1;34';
	const FORE_GREEN 		= '0;32';
	const FORE_LIGHT_GREEN 	= '1;32';
	const FORE_CYAN			= '0;36';
	const FORE_LIGHT_CYAN	= '1;36';
	const FORE_RED			= '0;31';
	const FORE_LIGHT_RED	= '1;31';
	const FORE_PURPLE		= '0;35';
	const FORE_LIGHT_PURPLE	= '1;35';
	const FORE_BROWN		= '0;33';
	const FORE_YELLOW		= '1;33';
	const FORE_LIGHT_GRAY	= '0;37';
	const FORE_WHITE		= '1;37';
	
	const BG_BLACK			= '40';
	const BG_RED			= '41';
	const BG_GREEN			= '42';
	const BG_YELLOW			= '43';
	const BG_BLUE			= '44';
	const BG_MAGENTA		= '45';
	const BG_CYAN			= '46';
	const BG_LIGHT_GRAY		= '47';
}

class Ansi_Cli {
	public static function Colored_String($string, $foreground_color = null, $background_color = null) {
		$colored_string = '';
		if (isset($foreground_color)) {
			$colored_string .= "\033[" . $foreground_color . 'm';
		}
		if (isset($background_color)) {
			$colored_string .= "\033[" . $background_color . 'm';
		}
		return $colored_string;
	}
}
