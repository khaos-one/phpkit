<?php
	
/** Class for outputting simple HTML templates. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Template {
	private $filename;
	private $vars;
	public function __construct($filename, $vars = null) {
		if (!is_readable($filename)) {
			throw new Exception("Template file `$filename` is unreadable.");
		}
		if (isset($vars)) {
			$this->vars = $vars;
		} else {
			$this->vars = array();
		}
	}
	public function Set($var, $value) {
		$this->vars[$var] = $value;
	}
	public function Render() {
		ob_start();
		extract($this->vars);
		include($this->filename);
		return ob_get_clean();
	}
	public function Output() {
		$html = $this->Render();
		echo($html);
	}
	public function Set_Sub($var, Template $template) {
		$this->vars[$var] = $template->Render();
	}
	protected function Template($filename) {
		$tpl = new Template($filename, $this->vars);
		$tpl->Output();
	}
}
