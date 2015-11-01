<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Nip_Model {
	protected $tableName = "setting";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $type;
	public $key;
	public $value;
	public $created;
	public $updated;
	public $deleted;

	protected $objects = array();
	
	protected $validator = array(
			'title' => 'required|max_length[255]',
			'type' => 'required|max_length[20]',
			'key' => 'required|max_length[255]',
			);
	
	protected $label = array(
			'title' => 'Title',
			'type' => 'Type',
			'key' => 'Key',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function __get($key)
	{
		$method = "get".ucfirst($key);
		if(method_exists($this, $method)){
			return $this->$method();
		}else{
			if(!empty($this->objects) && isset($this->objects[$key])){
				return $this->objects[$key];
			}
			
			return parent::__get($key);
		}
	}

	public function reorganize(){
		$data = array();
		foreach($this->objects as $row){
			$data[$row->key] = $row->value;
		}

		$this->objects = $data;
	}

	public function setObjects($objects){
		$this->objects = $objects;
		$this->reorganize();
		return $this;
	}

	public function setValues(){
		$objects = $this->all();
		$this->setObjects($objects);
		return $this;
	}
}