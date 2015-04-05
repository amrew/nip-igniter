<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends Nip_Model {
	protected $tableName = "post";
	protected $primary = "id";

	protected $softDeletes = TRUE;
	
	public $id;
	public $title;
	public $content;
	public $slug;
	public $category_id;
	public $type;
	public $status_id;
	public $author_id;
	public $image;
	public $thumb;
	public $parent_id = 0;
	public $order = 0;
	public $view_count = 0;
	public $comment_count = 0;
	public $allow_comment;
	public $meta_title;
	public $meta_description;
	public $publish_date;
	public $created;
	public $updated;
	public $deleted;
	
	protected $validator = array(
			'title' => 'required|max_length[255]',
			'content' => 'required',
			'slug' => 'required|max_length[255]',
			'type' => 'required|max_length[50]',
			'status_id' => 'required|numeric',
			'author_id' => 'required|numeric',
			'order' => 'required',
			'view_count' => 'required',
			'comment_count' => 'required',
			'publish_date' => 'required',
			);
	
	protected $label = array(
			'title' => 'Title',
			'content' => 'Content',
			'slug' => 'Slug',
			'type' => 'Type',
			'status_id' => 'Status',
			'author_id' => 'Author',
			'order' => 'Order',
			'view_count' => 'View Count',
			'comment_count' => 'Comment Count',
			'publish_date' => 'Publish Date',
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

	public function getUser(){
		return $this->belongsTo('User','author_id');
	}

	public function getSummary($limit = 30){
		return word_limiter(strip_tags($this->content), $limit);
	}

	public function beforeValidate(){
		if(empty($this->slug)){
			$this->slug = url_title($this->title, "-", TRUE);
		}
	}

	public function active(){
		$this->db->where("status_id = 1 AND publish_date <= now()");
		return $this;
	}

	public function getPathImage(){
		$pathImage = base_url().str_replace("./", '', $this->image);
		return $pathImage;
	}
}