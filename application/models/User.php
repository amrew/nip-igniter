<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Nip_Model {
	protected $tableName = "user";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $username;
	public $password;
	public $email;
	public $role_id;
	public $status_id;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'User[username]' => 'required|max_length[255]',
			'User[email]' => 'required|max_length[255]|valid_email',
			'User[role_id]' => 'required|numeric',
			'User[status_id]' => 'required|numeric',
			);
	
	protected $label = array(
			'User[username]' => 'Username',
			'User[email]' => 'Email',
			'User[role_id]' => 'Role',
			'User[status_id]' => 'Status',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function getRole(){
		return $this->belongsTo('Role','role_id');
	}

	public function getStatus(){
		return $this->belongsTo('Status','status_id');
	}

}