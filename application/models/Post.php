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
	public $parent_id;
	public $order;
	public $view_count;
	public $comment_count;
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
			'category_id' => 'required|numeric',
			'type' => 'required|max_length[50]',
			'status_id' => 'required|numeric',
			'author_id' => 'required|numeric',
			'parent_id' => 'required|max_length[11]',
			'order' => 'required',
			'view_count' => 'required',
			'comment_count' => 'required',
			'allow_comment' => 'required',
			'meta_title' => 'required|max_length[70]',
			'meta_description' => 'required',
			'publish_date' => 'required',
			);
	
	protected $label = array(
			'title' => 'Title',
			'content' => 'Content',
			'slug' => 'Slug',
			'category_id' => 'Category',
			'type' => 'Type',
			'status_id' => 'Status',
			'author_id' => 'Author',
			'parent_id' => 'Parent',
			'order' => 'Order',
			'view_count' => 'View Count',
			'comment_count' => 'Comment Count',
			'allow_comment' => 'Allow Comment',
			'meta_title' => 'Meta Title',
			'meta_description' => 'Meta Description',
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

}