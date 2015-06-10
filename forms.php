<?php
	
/** Class for managing HTML forms submission. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

require_once('input.php');

class Form_Field {
	const VALIDATE_REGEX_EMAIL = '\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b';
	
	const ERROR_REQUIRED 			= 1;
	const ERROR_VALIDATION_FN 		= 2;
	const ERROR_VALIDATION_FILTER 	= 4;
	const ERROR_VALIDATION_REGEX 	= 8;
	const ERROR_MAX_LENGTH			= 16;
	const ERROR_MIN_LENGTH			= 32;
	
	public $Name;
	public $Value;
	public $Required;
	public $Max_Length;
	public $Min_Length;
	public $Validation_Fn;
	public $Validation_Filter_Var;
	public $Validation_Regex;
	public $Errors;
	
	public function __construct($name, $required = false) {
		$this->Name = $name;
		$this->Required = $required;
		$this->Errors = 0;
	}
	public function Load_Post() {
		$this->Value = Input::Post($this->Name);
	}
	public function Validate() {
		if (!isset($this->Value)) {
			if ($this->Required) {
				$this->Errors |= self::ERROR_REQUIRED;
			}
			return !$this->Required;
		}
		$result = true;
		if (isset($this->Validation_Fn) && is_callable($this->Validation_Fn)) {
			$res = call_user_func($this->Validation_Fn);
			if (!$res) {
				$this->Errors |= self::ERROR_VALIDATION_FN;
				$result = false;
			}
		} else if (isset($this->Validation_Filter_Var)) {
			$res = filter_var($this->Value, $this->Validation_Filter_Var);
			if (!$res) {
				$this->Errors |= self::ERROR_VALIDATION_FILTER;
				$result = false;
			}
		} else if (isset($this->Validation_Regex)) {
			$res = preg_match($this->Validation_Regex, $this->Value);
			if (!$res) {
				$this->Errors |= self::ERROR_VALIDATION_REGEX;
				$result = false;
			}
		}
		if (isset($this->Max_Length)) {
			$res = strlen($this->Value) <= $this->Max_Length;
			if (!$res) {
				$this->Errors |= self::ERROR_MAX_LENGTH;
				$result = false;
			}
		}
		if (isset($this->Min_Length)) {
			$res = strlen($this->Value) >= $this->Min_Length;
			if (!$res) {
				$this->Errors |= self::ERROR_MIN_LENGTH;
				$result = false;
			}
		}
		return $result;
	}
}

class Form {
	private $fields;
	public function __construct() {
		$this->fields = array();
	}
	public function Field(Form_Field $field) {
		$this->fields[$field->Name] = $field;
	} 
	public function Load_Post() {
		foreach ($this->fields as $field) {
			$field->Load_Post();
		}
	}
	public function Validate() {
		$result = true;
		foreach ($this->fields as $field) {
			$result = $result & $field->Validate();
		}
		return $result;
	}
}