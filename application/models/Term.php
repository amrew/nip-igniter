<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Term extends Nip_Model {
	protected $tableName = "term";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $description;
	public $slug;
	public $type;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'title' => 'required|max_length[255]',
			'description' => 'required',
			'slug' => 'required|max_length[255]',
			'type' => 'required|max_length[50]',
			);
	
	protected $label = array(
			'title' => 'Title',
			'description' => 'Description',
			'slug' => 'Slug',
			'type' => 'Type',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
}