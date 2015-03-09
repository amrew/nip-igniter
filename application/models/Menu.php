<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends Nip_Model {
	protected $tableName = "menu";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $controller;
	public $params;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'title' => 'required|max_length[255]',
			'controller' => 'required|max_length[255]',
			);
	
	protected $label = array(
			'title' => 'Title',
			'controller' => 'Controller',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
}