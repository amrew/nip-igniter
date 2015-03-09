<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends Nip_Model {
	protected $tableName = "comment";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $post_id;
	public $name;
	public $email;
	public $website;
	public $message;
	public $type;
	public $status_id;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'post_id' => 'required|numeric',
			'name' => 'required|max_length[255]',
			'email' => 'required|max_length[100]|valid_email',
			'website' => 'required|max_length[100]',
			'message' => 'required',
			'type' => 'required|max_length[255]',
			'status_id' => 'required|numeric',
			);
	
	protected $label = array(
			'post_id' => 'Post',
			'name' => 'Name',
			'email' => 'Email',
			'website' => 'Website',
			'message' => 'Message',
			'type' => 'Type',
			'status_id' => 'Status',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function getPost(){
		return $this->belongsTo('Post','post_id');
	}

	public function getStatus(){
		return $this->belongsTo('Status','status_id');
	}

}