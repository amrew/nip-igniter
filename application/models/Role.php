<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends Nip_Model {
	protected $tableName = "role";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'Role[title]' => 'required|max_length[100]',
			);
	
	protected $label = array(
			'Role[title]' => 'Title',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
}