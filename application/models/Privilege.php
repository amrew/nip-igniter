<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege extends Nip_Model {
	protected $tableName = "privilege";
	protected $primary = "id";

	public $id;
	public $menu_id;
	public $role_id;
	public $view=0;
	public $create=0;
	public $update=0;
	public $delete=0;
	public $trash=0;
	public $restore=0;
	public $delete_permanent=0;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'menu_id' => 'required|numeric',
			'role_id' => 'required|numeric',
			);
	
	protected $label = array(
			'menu_id' => 'Menu',
			'role_id' => 'Role',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function getMenu(){
		return $this->belongsTo('Menu','menu_id');
	}

	public function getRole(){
		return $this->belongsTo('Role','role_id');
	}

}