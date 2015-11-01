<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends Nip_Model {
	protected $tableName = "menu";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $url;
	public $parent_menu_id = 0;
	public $controller;
	public $params;
	public $order = 0;
	public $icon = 'fa fa-table';
	public $core = 0;
	public $created;
	public $updated;
	public $deleted;

	protected $deletedField = "menu.deleted";
	
	protected $validator = array(
			'title' => 'required|max_length[255]',
			);
	
	protected $label = array(
			'title' => 'Title',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function getMenu(){
		return $this->belongsTo('Menu','parent_menu_id');
	}

}