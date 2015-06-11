<?php

/**
 * Module contains API for managing ANSI terminals
 * input-outpput operations.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

/**
 * Class-container for ANSI color codes.
 */
class Ansi_Color {
    /** Black foreground code. */
	const FORE_BLACK 		= '0;30';
    /** Dark gray foreground code. */
	const FORE_DARK_GRAY 	= '1;30';
    /** Blue foreground code. */
	const FORE_BLUE 		= '0;34';
    /** Light blue foreground code. */
	const FORE_LIGHT_BLUE 	= '1;34';
    /** Green foreground code. */
	const FORE_GREEN 		= '0;32';
    /** Light green foreground code. */
	const FORE_LIGHT_GREEN 	= '1;32';
    /** Cyan foreground code. */
	const FORE_CYAN			= '0;36';
    /** Light cyan foreground code. */
	const FORE_LIGHT_CYAN	= '1;36';
    /** Red foreground code. */
	const FORE_RED			= '0;31';
    /** Light red foreground code. */
	const FORE_LIGHT_RED	= '1;31';
    /** Purple foreground code. */
	const FORE_PURPLE		= '0;35';
    /** Light purple foreground code. */
	const FORE_LIGHT_PURPLE	= '1;35';
    /** Brown foreground code. */
	const FORE_BROWN		= '0;33';
    /** Yellow foreground code. */
	const FORE_YELLOW		= '1;33';
    /** Light gray foreground code. */
	const FORE_LIGHT_GRAY	= '0;37';
    /** White foreground code. */
	const FORE_WHITE		= '1;37';

    /** Black background code. */
	const BG_BLACK			= '40';
    /** Red background code. */
	const BG_RED			= '41';
    /** Green background code. */
	const BG_GREEN			= '42';
    /** Yellow background code. */
	const BG_YELLOW			= '43';
    /** Blue background code. */
	const BG_BLUE			= '44';
    /** Magenta background code. */
	const BG_MAGENTA		= '45';
    /** Cyan background code. */
	const BG_CYAN			= '46';
    /** Light gray background code. */
	const BG_LIGHT_GRAY		= '47';
}

/**
 * Class for managing ANSI terminals I/O.
 */
class Ansi_Cli {
    /**
     * Returns color-formatted string for outputting to
     * ANSI terminal.
     *
     * @param string
     * @param null $foreground_color
     * @param null $background_color
     * @return string
     */
	public static function Colored_String($string, $foreground_color = null, $background_color = null) {
		$colored_string = '';
		if (isset($foreground_color)) {
			$colored_string .= "\033[" . $foreground_color . 'm';
		}
		if (isset($background_color)) {
			$colored_string .= "\033[" . $background_color . 'm';
		}
		return $colored_string.$string;
	}
}
