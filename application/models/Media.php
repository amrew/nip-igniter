<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends Nip_Model {
	protected $tableName = "media";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $description;
	public $type;
	public $url;
	public $thumb;
	public $method;
	public $category_id;
	public $status_id = 1;
	public $view_count = 0;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'title' => 'required|max_length[255]',
			'type' => 'required|max_length[255]',
			'method' => 'required|max_length[255]',
			'category_id' => 'required|numeric',
			'status_id' => 'required|numeric',
			);
	
	protected $label = array(
			'title' => 'Title',
			'type' => 'Type',
			'method' => 'Method',
			'category_id' => 'Category',
			'status_id' => 'Status',
			);

	public function __construct($options = array()){
		parent::__construct($options);
	}
	
	public function getTerm(){
		return $this->belongsTo('Term','category_id');
	}

	public function getStatus(){
		return $this->belongsTo('Status','status_id');
	}

	public function getPath(){
		if($this->method == "url"){
			if(strpos($this->url, 'youtube') !== false){
				
				$url = $this->url;

				preg_match(
				        '/[\\?\\&]v=([^\\?\\&]+)/',
				        $url,
				        $matches
				    );
				$id = $matches[1];

				return "//www.youtube.com/v/{$id}&amp;hl=en_US&amp;fs=1?rel=0";
			}

			return $this->url;
		}else{
			return base_url().$this->url;
		}
	}

}