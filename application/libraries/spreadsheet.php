<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spreadsheet{

	public $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
	}

	public function send($filename = ""){
		header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
	}

	public function write($value = ""){
		echo $value. "\t";
	}
}