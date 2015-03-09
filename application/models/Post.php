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
	public $status_id = 2;
	public $author_id;
	public $image;
	public $thumb;
	public $parent_id = 0;
	public $order = 0;
	public $view_count = 0;
	public $comment_count = 0;
	public $allow_comment = NULL;
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
			);
	
	protected $label = array(
			'title' => 'Title',
			'content' => 'Content',
			'slug' => 'Slug',
			'type' => 'Type',
			'status_id' => 'Status',
			'author_id' => 'Author',
			);

	public function __construct($options = array()){
		parent::__construct($options);
		$this->publish_date = date("Y-m-d");
	}

	public function beforeValidate(){
		if(empty($this->slug)){
			$this->slug = url_title($this->title, '-', TRUE);
		}
	}
	
	public function getTerm(){
		$result = $this->belongsTo('Term','category_id');
		if(empty($result)){
			$result = new Term();
		}
		return $result;
	}

	public function getCategory(){
		return $this->getTerm();
	}

	public function getStatus(){
		$result =$this->belongsTo('Status','status_id');
		if(empty($result)){
			$result = new Status();
		}
		return $result;
	}

	public function getUser(){
		$result = $this->belongsTo('User','author_id');
		if(empty($result)){
			$result = new User();
		}
		return $result;
	}

	public function getPost(){
		$result = $this->belongsTo('Post','parent_id');
		if(empty($result)){
			$result = new Post();
		}
		return $result;
	}

	public function getParent(){
		return $this->getPost();
	}

	//----------------------------
	public function getSummary(){
		$summary = word_limiter(strip_tags($this->content), 30);
		return $summary;
	}

	public function getPathImage(){
		$pathImage = base_url().str_replace("./", '', $this->image);
		return $pathImage;
	}

	public function date(){
		return date("d M Y", strtotime($this->updated));
	}

	public function saveTags($data){
		if(!empty($data)){
			if($this->PostTerm->delete(array("post_id" => $this->id))) {
				
				foreach($data as $value) {

					$postTerm = new PostTerm();
					$postTerm->post_id = $this->id;
					$postTerm->term_id = $value;
					$postTerm->save();

				}
			}
		}
	}

	public function getTags(){
		$array = array();
		if(!empty($this->id)){
			$postTerms = $this->PostTerm->all(array("where" => array("post_id" => $this->id)));
			foreach($postTerms as $each){
				$array[] = $each->term_id;
			}
		}

		return $array;
	}

	public function publish(){
		$this->db->where(array("status_id"=>1, "publish_date <="=>date("Y-m-d H:i:s")));
		return $this;
	}

	public function draft(){
		$this->db->where(array("status_id"=>1, "publish_date >="=>date("Y-m-d H:i:s")));
		$this->db->or_where(array("status_id"=>2));
		return $this;
	}
}