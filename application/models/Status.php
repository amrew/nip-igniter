<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends Nip_Model {
	protected $tableName = "status";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'Status[title]' => 'required|max_length[255]',
			);
	
	protected $label = array(
			'Status[title]' => 'Title',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
}