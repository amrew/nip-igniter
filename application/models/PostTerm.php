<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PostTerm extends Nip_Model {
	protected $tableName = "post_term";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $post_id;
	public $term_id;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'post_id' => 'required|numeric',
			'term_id' => 'required|numeric',
			);
	
	protected $label = array(
			'post_id' => 'Post',
			'term_id' => 'Term',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function getPost(){
		return $this->belongsTo('Post','post_id');
	}

	public function getTerm(){
		return $this->belongsTo('Term','term_id');
	}

}