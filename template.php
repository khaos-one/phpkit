<?php

/**
 * Package containing objects for
 * outputting simple HTML templates.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

class Template {
	private $filename;
	private $vars;
	public function __construct($filename, $vars = null) {
		if (!is_readable($filename)) {
			throw new Exception("Template file `$filename` is unreadable.");
		}
		$this->filename = $filename;
		if (isset($vars)) {
			$this->vars = $vars;
		} else {
			$this->vars = array();
		}
	}
	public function Set($var, $value) {
		$this->vars[$var] = $value;
	}
	public function Merge($vars) {
		$this->vars = array_merge($this->vars, $vars);
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
	protected function Get_In_Array($arr, $var) {
		if (!isset($this->vars[$arr])) {
			return false;
		}
		if (!isset($this->vars[$arr][$var])) {
			return false;
		}
		return $this->vars[$arr][$var];
	}
	protected function Isset_Print($var) {
		if (isset($this->vars[$var])) {
			echo($this->vars[$var]);
		}
	}
	protected function Isset_Print_Value($var) {
		if (isset($this->vars[$var])) {
			echo('value="'.$this->vars[$var].'"');
		}
	}
	protected static function Render_Template($filename, $vars = null) {
		$tpl = new Template($filename, $vars);
		return $tpl->Render();
	}
	protected static function Output_Template($filename, $vars = null) {
		$tpl = new Template($filename, $vars);
		$tpl->Output();
	}
}
