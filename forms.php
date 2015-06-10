<?php
	
/** Class for managing HTML forms submission. */
/** By Egor 'khaos' Zelensky, 2015. */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

require_once('input.php');

class Form_Field {
	const VALIDATE_REGEX_EMAIL = '\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b';
	
	public $Name;
	public $Value;
	public $Required;
	public $Max_Length;
	public $Min_Length;
	public $Validation_Fn;
	public $Validation_Filter_Var;
	public $Validation_Regex;
	
	public function __construct($name, $required = false) {
		$this->Name = $name;
		$this->Required = $required;
	}
	public function Load_Post() {
		$this->Value = Input::Post($this->Name);
	}
	public function Validate() {
		if (!isset($this->Value)) {
			return !$this->Required;
		}
		$result = true;
		if (isset($this->Validation_Fn) && is_callable($this->Validation_Fn)) {
			$result = call_user_func($this->Validation_Fn);
		} else if (isset($this->Validation_Filter_Var)) {
			$result = filter_var($this->Value, $this->Validation_Filter_Var);
		} else if (isset($this->Validation_Regex)) {
			$result = preg_match($this->Validation_Regex, $this->Value);
		}
		if (isset($this->Max_Length)) {
			$result = strlen($this->Value) <= $this->Max_Length;
		}
		if (isset($this->Min_Length)) {
			$result = strlen($this->Value) >= $this->Min_Length;
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