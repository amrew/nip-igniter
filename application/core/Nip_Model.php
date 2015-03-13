<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @license    https://ellislab.com/codeigniter/user-guide/license.html  Codeigniter
 * @version    2.0
 * @link       http://nipstudio.com
 */
class Nip_Model extends CI_Model {
	
	/**
	 * Class name
	 *
	 * @var string
	 * @access protected
	 */
	protected $className;

	/**
	 * Table name for this model
	 *
	 * @var string
	 * @access protected
	 */
	protected $tableName;

	/**
	 * Primary key for this model
	 *
	 * @var string
	 * @access protected
	 */
	protected $primary;

	/**
	 * Activate trash feature or not
	 *
	 * @var boolean
	 * @access protected
	 */
	protected $softDeletes = FALSE;

	/**
	 * Trash data will be returned
	 *
	 * @var boolean
	 * @access protected
	 */
	protected $justTrash = FALSE;

	/**
	 * Activate timestamps feature or not
	 *
	 * @var boolean
	 * @access protected
	 */
	protected $timestamps = TRUE;

	/**
	 * Validator configuration
	 *
	 * @var mix
	 * @access protected
	 */
	protected $validator = array();

	/**
	 * Validator message when error on validate
	 *
	 * @var mix
	 * @access protected
	 */
	protected $messageArray = array();

	/**
	 * Validator message when error on validate
	 *
	 * @var string
	 * @access protected
	 */
	protected $messageString;

	/**
	 * Created field for timestamps
	 *
	 * @var string
	 * @access protected
	 */
	protected $createdField = "created";

	/**
	 * Updated field for timestamps
	 *
	 * @var string
	 * @access protected
	 */
	protected $updatedField = "updated";

	/**
	 * Deleted field for timestamps
	 *
	 * @var string
	 * @access protected
	 */
	protected $deletedField = "deleted";

	/**
	 * Save relationship object
	 *
	 * @var mix
	 * @access protected
	 */
	protected $relationship = array();
	
	/**
     * Get current class name
     * 
     * @param mix 	$options Set each field with value
     * @return void
     *
     * @access public
     */
	public function __construct($options = array()){
		parent::__construct();
		$this->attr($options);
		$this->className = get_class($this);
	}

	/**
     * Show class name if an object will be shown with 'echo'
     * 
     * @return string
     *
     * @access public
     */
	public function __toString(){
		return $this->className;
	}

	/**
     * Mengecek dan memanggil suatu method jika $key yang dipanggil tidak ada
     * 
     * Contoh
     * $object->some
     * akan memanggil
     * $object->getSome
     * 
     * Digunakan untuk relationship
     * 
     * @param string $key
     * @return void
     *
     * @access public
     */
	public function __get($key)
	{
		$method = "get".ucfirst($key);
		if(method_exists($this, $method)){
			return $this->$method();
		}else{
			return parent::__get($key);
		}
	}

	public function getProperties(){
		$reflect = new ReflectionClass($this);
		$properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

		$data = array();
		foreach($properties as $prop){
			$data[] = $prop->name;
		}

		return $data;
	}
	
	/**
     * Set each variable value
     * 
     * @param mix 	$attributes 
     * @return void
     *
     * @access public
     */
	public function attr($attributes = array(), $value = NULL){
		if(is_array($attributes)){
			foreach($attributes as $key => $value){
				if(property_exists($this,$key)){
					$this->$key = $value;
				}
			}
		}else{
			$this->$attributes = $value;
		}
	}

	/**
	 * Checking timestamps
	 *
	 * @access protected
	 */
	protected function checkTimestamps(){
		if($this->timestamps){
			if($this->softDeletes){
				$this->db->where("{$this->deletedField} IS NULL ");
			}else if($this->justTrash){
				$this->db->where("{$this->deletedField} IS NOT NULL ");
			}
		}
	}

	/**
	 * Remove unexpected field on the object before save
	 *
	 * @access protected
	 */
	protected function cleanObject(){
		$default = new $this->className();

		foreach($this as $key => $value){
			if(!property_exists($default, $key)){
				unset($this->$key);
			}
		}
	}
	
	/**
     * return one row from the current table
     * 
     * @param mix|string 	$where
     * @param string 		$orderBy
     * @param integer 		$offset
     * @param mix|string 	$fields
     * @return object
     *
     * @access public
     */
	public function first($where = NULL, $orderBy = NULL, $offset = 0, $fields = NULL){
		
		$this->checkTimestamps();
		
		if($where){
			if(is_numeric($where)){
				$this->db->where(array($this->primary => $where));
			}else{
				$this->db->where($where);
			}
		}

		if($fields){
			if(is_array($fields)){
				$this->db->select(implode(",", $fields));
			}else if(is_string($fields)){
				$this->db->select($fields, FALSE);
			}
		}

		if($orderBy){
			$this->db->order_by($orderBy);
		}

		$this->db->limit(1, $offset);

		$query = $this->db->get($this->tableName);
		$data  = $query->row_array();

		if(!empty($data)){
			$model = new $this->className();
			$model->attr($data);
			
			return $model;
		}
		return NULL;
	}

	/**
     * return the last one row from the current table by primary
     * 
     * @param mix|string 	$where
     * @param string 		$orderBy
     * @param integer 		$offset
     * @param mix|string 	$fields
     * @return object
     *
     * @access public
     */
	public function last($where = NULL, $orderBy = NULL, $offset = 0, $fields = NULL){
		
		if($orderBy === NULL){
			$orderBy = "{$this->primary} desc";
		}

		return $this->first($where, $orderBy, $offset, $fields);
	}

	/**
     * return all row from the current table with some parameter config
     * 
     * @param mix 	$config
     * @return mix
     *
     * @access public
     */
	public function all($config = array()){

		$this->checkTimestamps();
		
		if(!empty($config)){

			if(isset($config['where']) && !empty($config['where'])){
				$where = $config['where'];
				
				$this->db->where($where);
			}

			if(isset($config['or_where']) && !empty($config['or_where'])){
				$where = $config['or_where'];
				
				$this->db->or_where($where);
			}

			if(isset($config['like']) && !empty($config['like'])){
				$where = $config['like'];
				
				foreach($where as $key=>$val){
					$this->db->like($key, $val);
				}
			}

			if(isset($config['or_like']) && !empty($config['or_like'])){
				$where = $config['or_like'];
				
				foreach($where as $key=>$val){
					$this->db->or_like($key, $val);
				}
			}

			if(isset($config['fields']) && !empty($config['fields'])){
				$fields = $config['fields'];
				
				if(is_array($fields)){
					$this->db->select(implode(",", $fields));
				}else if(is_string($fields)){
					$this->db->select($fields, FALSE);
				}
			}
			
			if(isset($config['group_by']) && !empty($config['group_by'])){
				$groupBy = $config['group_by'];
				
				$this->db->group_by($groupBy);
			}

			if(isset($config['order_by']) && !empty($config['order_by'])){
				$orderBy = $config['order_by'];
				
				$this->db->order_by($orderBy);
			}

			if(isset($config['limit']) && !empty($config['limit'])){
				$limit = $config['limit'];
	
				if(isset($config['offset']) && !empty($config['offset'])){
					$offset = $config['offset'];
					$this->db->limit($limit, $offset);
				}else{
					$this->db->limit($limit);
				}
			}

			if(isset($config['join']) && !empty($config['join'])){
				$join = $config['join'];

				foreach($join as $table => $on){
					$this->db->join($table, $on);
				}
			}

			if(isset($config['left_join']) && !empty($config['left_join'])){
				$join = $config['left_join'];

				foreach($join as $table => $on){
					$this->db->join($table, $on, "left");
				}
			}

			if(isset($config['right_join']) && !empty($config['right_join'])){
				$join = $config['right_join'];

				foreach($join as $table => $on){
					$this->db->join($table, $on, "right");
				}
			}
		}
		
		$query = $this->db->get($this->tableName);

		$models = array();
		foreach($query->result_array() as $row){
			$model = new $this->className();

			foreach($row as $key => $value){
				$model->attr($key, $value);
			}
			
			array_push($models, $model);
		}
		return $models;
	}
	
	/**
     * return count row
     * 
     * @param mix 	$where
     * @return integer
     *
     * @access public
     */
	public function count($where = NULL){
		
		$this->checkTimestamps();

		if($where){
			$this->db->where($where);
		}
		return $this->db->count_all_results($this->tableName);
	}
	
	/**
     * save the current object
     * 
     * if the primary field is empty then it's save as new row
     * if the primary field is not empty then it's update the old row
     * 
     * @return integer
     *
     * @access public
     */
	public function save(){

		$this->cleanObject();

		if($this->{$this->primary}){
			$this->db->where(array($this->primary => $this->{$this->primary}));
			
			if($this->timestamps){
				$this->{$this->updatedField} = date("Y-m-d H:i:s");
			}

			$object = clone($this);
			unset($object->{$this->primary});

			return $this->db->update($this->tableName, $object);
		}else{

			if($this->timestamps){
				$this->{$this->createdField} = date("Y-m-d H:i:s");
				$this->{$this->updatedField} = date("Y-m-d H:i:s");
			}

			$this->db->insert($this->tableName, $this);
			
			$this->{$this->primary} = $this->db->insert_id();
			
			return $this->{$this->primary};
		}
	}
	
	/**
     * delete the current object or based on some parameter
     * 
     * @param mix 	$where
     * @return boolean
     *
     * @access public
     */
	public function delete($where = NULL){
		if($this->softDeletes){
			if($where){
				if(is_numeric($where)){
					$this->db->where(array($this->primary => $where));
				}else{
					$this->db->where($where);
				}

				return $this->db->update($this->tableName, array("{$this->deletedField}" => date("Y-m-d H:i:s")));
			} else {
				if($this->{$this->primary}) {
					$this->db->where(array($this->primary => $this->{$this->primary}));
					return $this->db->update($this->tableName, array("{$this->deletedField}" => date("Y-m-d H:i:s")));
				}
			}
		}else{
			return $this->forceDelete($where);
		}

		return FALSE;
	}

	/**
     * force delete the current object or based on some parameter
     * 
     * @param mix 	$where
     * @return boolean
     *
     * @access public
     */
	public function forceDelete($where = NULL){	
		if($where){
			if(is_numeric($where)){
				$this->db->where(array($this->primary => $where));
			} else {
				$this->db->where($where);
			}

			return $this->db->delete($this->tableName);
		}else{
			if($this->{$this->primary}){
				$this->db->where(array($this->primary => $this->{$this->primary}));
				return $this->db->delete($this->tableName);
			}
		}
		
		return FALSE;
	}

	/**
     * restore some row from trash
     * 
     * @param mix 	$where
     * @return boolean
     *
     * @access public
     */
	public function restore($where = NULL){
		if($where){
			if(is_numeric($where)){
				$this->db->where(array($this->primary => $where));
			} else {
				$this->db->where($where);
			}

			return $this->db->update($this->tableName, array("{$this->deletedField}" => NULL));
		} else {
			if($this->{$this->primary}){
				$this->db->where(array($this->primary => $this->{$this->primary}));
				return $this->db->update($this->tableName, array("{$this->deletedField}" => NULL));
			}
		}

		return FALSE;
	}

	/**
     * validate form with some configuration
     * 
     * @return boolean
     *
     * @access public
     */
	public function validate(){
		if(!empty($this->validator)){
			$this->load->library("form_validation");
			
			$conf = $this->getConf();
			$this->form_validation->set_rules($conf);
			
			$temp = array();

			if($this->form_validation->run($this) == FALSE){
				$this->messageString = validation_errors();

				foreach($this->validator as $field => $rules){
					$temp[$field] = form_error($field);
				}
				$this->messageArray = $temp;

				return FALSE;
			}
		}
		return TRUE;
	}

	/**
     * set configuration for validator
     * 
     * @return boolean
     *
     * @access protected
     */
	protected function getConf(){
		$conf = array();

		foreach ($this->validator as $field => $rules) {
			$temp["field"] = $field;
			$temp["rules"] = $rules;
			$temp["label"] = $this->label[$field]?$this->label[$field]:"fields";

			$conf[] = $temp;
		}

		return $conf;
	}

	/**
     * Change justTrash status variable
     * 
     * @return this
     *
     * @access public
     */
	public function justTrash(){
		$this->softDeletes = FALSE;
		$this->justTrash   = TRUE;
		return $this;
	}

	/**
     * Change justTrash status variable
     * 
     * @return this
     *
     * @access public
     */
	public function withTrash(){
		$this->softDeletes = FALSE;
		$this->justTrash   = FALSE;
		return $this;	
	}

	/**
     * Mengembalikan object yang berelasi belongsTo
     * 
     * @return object
     *
     * @access public
     */
	public function belongsTo($modelName = NULL, $foreignKey = NULL){
		if($modelName){

			if(is_null($foreignKey)){
				$foreignKey = getUnderscoredClass($modelName)."_id";
			}
			
			if(in_array($foreignKey, $this->relationship)){
				return $this->relationship[$foreignKey];
			}

			$ci =& get_instance();
			$ci->load->model($modelName);

			$row = $ci->{$modelName}->first($this->{$foreignKey});

			if(empty($row)){
				return new $this->className();
			}

			$this->relationship[$foreignKey] = $row;
			return $row;
		}
		return NULL;
	}

	/**
     * Mengembalikan object yang berelasi hasOne
     * 
     * @return object
     *
     * @access public
     */
	public function hasOne($modelName = NULL, $foreignKey = NULL ){
		if($modelName){
			if(is_null($foreignKey)){
				$foreignKey = getUnderscoredClass($this->className)."_id";
			}

			if(in_array($foreignKey, $this->relationship)){
				return $this->relationship[$foreignKey];
			}

			$ci =& get_instance();
			$ci->load->model($modelName);

			$row = $ci->{$modelName}->first(array($foreignKey => $this->{$this->primary}));
			
			if(empty($row)){
				return new $this->className();
			}

			$this->relationship[$foreignKey] = $row;
			return $row;
		}
		return NULL;
	}

	/**
     * Mengembalikan object yang berelasi hasMany
     * 
     * @return object
     *
     * @access public
     */
	public function hasMany($modelName = NULL, $foreignKey = NULL ){
		if($modelName){
			if(is_null($foreignKey)){
				$foreignKey = getUnderscoredClass($this->className)."_id";
			}

			if(in_array($foreignKey, $this->relationship)){
				return $this->relationship[$foreignKey];
			}

			$ci =& get_instance();
			$ci->load->model($modelName);

			$array = $ci->{$modelName}->all(array($foreignKey => $this->{$this->primary}));

			if(!empty($array)){
				$this->relationship[$foreignKey] = $array;
			}

			return $array;
		}
		return NULL;
	}

	public function messageArray(){
		return $this->messageArray;
	}

	public function messageString(){
		return $this->messageString;
	}

	public function getSoftDeletes(){
		return $this->softDeletes;
	}

	public function getTimestamps(){
		return $this->timestamps;
	}

	public function getPrimary(){
		return $this->primary;
	}

	public function getClassName(){
		return $this->className;
	}

	public function getCreatedField(){
		return $this->createdField;
	}

	public function getUpdatedField(){
		return $this->updatedField;
	}

	public function getDeletedField(){
		return $this->deletedField;
	}
	
}