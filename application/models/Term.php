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
			'slug' => 'max_length[255]|is_unique[term.slug]',
			'type' => 'required|max_length[50]',
			);
	
	protected $label = array(
			'title' => 'Title',
			'slug' => 'Slug',
			'type' => 'Type',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}

	public function beforeValidate(){
		if(empty($this->slug)){
			$this->slug = url_title($this->title, '-', TRUE);
		}

		$this->validator['slug'] = 'max_length[255]|is_edit_unique[term.slug.id.'.$this->id.']';
	}
	
}