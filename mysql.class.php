<?php
	
/** By Egor 'khaos' Zelensky, 2015. */
	
if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }
	
class MySql {
	private $mysqli;
	
	public function __construct($host, $user, $password, $db) {
		$this->mysqli = new mysqli($host, $user, $password, $db);
		if ($this->mysqli->connect_error) {
			throw new Exception('Connect error (' . $this->mysqli->connect_errno . '): ' . $this->mysqli->connect_error);
		}
	}
	
	public function __destruct() {
		$this->mysqli->close();
	}
	
	public function Query($sql, $type_spec = null, array $vars = null) {
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		if ($type_spec != null && $vars != null) {
			$params = array();
			$params[] = &$type_spec;
			for ($i = 0; $i < count($vars); $i++) {
				$params[] = &$vars[$i];
			}
			call_user_func_array(array($stmt, 'bind_param'), $params);
		}
		if ($stmt->execute() === false) {
			throw new Exception('Statement error: ' . $stmt->error);
		}
		$result = $stmt->get_result();
		$stmt->close();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
}