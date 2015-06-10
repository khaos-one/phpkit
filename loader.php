<?php
	
/** Loader script to load all needed parts of the core. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

require_once('input.php');
require_once('output.php');
require_once('mysql.php');
require_once('template.php');
require_once('mail.php');
