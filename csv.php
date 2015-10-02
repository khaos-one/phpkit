<?php


/**
 * CSV class manages interactions with CSV file format.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }
	
class CSV {
	public $delimiter;
	public $enclosure;
	public $header;
	public $content;
	
	public function __construct($delimiter = ',', $enclosure = '"') {
		$this->delimiter = $delimiter;
		$this->enclosure = $enclosure;
	}
	
	public static function From_File($filepath, $delimiter = ',', $enclosure = '"') {
		$instance = new CSV($delimiter, $enclosure);
		if (($fh = fopen($filepath. 'r')) !== false) {
			$instance->header = fgetcsv($fh, 0, $instance->delimiter, $instance->enclosure);
			$instancev->content = array();
			while (($data = fgetcsv($fh, 0, $instance->delimiter, $instance->enclosure)) !== false) {
				$cnt = array();
				for ($i = 0; $i < count($data); $i++) {
					$cnt[$this->header[$i]] = $data[$i];
				}
				$instance->content[] = $cnt;
			}
			fclose($fh);
		}
		return $instance;
	}
	
	public function To_File($filepath) {
		if (($fh = fopen($filepath, 'w')) !== false) {
			fputcsv($fh, $this->header, $this->delimiter, $this->enclosure);
			for ($i = 0; $i < count($this->content); $i++) {
				fputcsv($fh, array_values($this->content[$i]), $this->delimiter, $this->enclosure);
			}
			fclose($fh);
		}
	}
}
