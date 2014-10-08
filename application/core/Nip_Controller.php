<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @license    https://ellislab.com/codeigniter/user-guide/license.html  Codeigniter
 * @version    2.0
 * @link       http://nipstudio.com
 */
class Nip_Controller extends CI_Controller 
{
	
	/**
	 * Activated the _remap() function for login
	 *
	 * @var string
	 * @access protected
	 */
	protected $authStatus = TRUE;

	/**
	 * Title of page
	 *
	 * @var string
	 * @access public
	 */
	public $pageTitle;

	/**
	 * Partial view
	 *
	 * @var string
	 * @access public
	 */
	public $pageContent;

	/**
	 * Layout view path
	 *
	 * @var string
	 * @access public
	 */
	public $pageLayout = "layouts/main";

	/**
	 * Controller folder name
	 *
	 * @var string
	 * @access public
	 */
	public $folder = null;

	/**
	 * Controller name in the current URL
	 *
	 * @var string
	 * @access public
	 */
	public $controller;

	/**
	 * Action name in the current URL
	 *
	 * @var string
	 * @access public
	 */
	public $action;

	/**
	 * Combination of URL to view folder
	 *
	 * @var string
	 * @access public
	 */
	public $view;

	/**
	 * Controller Segment on URL
	 *
	 * @var integer
	 * @access public
	 */
	protected $controllerSegment = 1;

	/**
	 * Action Segment on URL
	 *
	 * @var integer
	 * @access public
	 */
	protected $actionSegment = 2;
	
	/**
	 * Redirect url to login form
	 *
	 * @var string
	 * @access public
	 */
	protected $loginFormUrl = 'auth';

	/**
	 * Action rules for user
	 *
	 * @var mix
	 * @access public
	 */
	protected $rules = array(
		'*' => array(),
		'1' => array("*"),  //admin
		'2' => array() 		//member
	);

	/**
     * This method is used for authentication. 
     * Check session login based on user_id and role_id.
     * You must have user table and role table.
     * 
     * @param string 	$method
     * @param mix 		$params
     *
     * @return void
     *
     * @access public
     */
	public function _remap($method, $params = array()) {
		
		if($this->authStatus) {

			$roleId = $this->session->userdata('role_id');
			$userId = $this->session->userdata('user_id');

			$allAllowedMethod = $this->rules['*'];

			if (!empty($allAllowedMethod)) {
					
				if (in_array('*', $allAllowedMethod) || in_array($method, $allAllowedMethod)) {
					
					if (method_exists($this, $method)) {
						return call_user_func_array(array($this, $method), $params);
					}
					
					show_404();
					return;
				}
			}

			if (!empty($roleId) && !empty($userId)) {

				$userRules = $this->rules[$roleId];

				if (!empty($userRules)) {

					if (in_array('*', $userRules) || in_array($method, $userRules)) {
						
						if (method_exists($this, $method)) {
							return call_user_func_array(array($this, $method), $params);
						}
						
						show_404();
						return;
					}
				}
			}

			redirect($this->loginFormUrl);

		} else {

			if (method_exists($this, $method)) {
				return call_user_func_array(array($this, $method), $params);
			}
			
			show_404();
			return;
		}
	}

	/**
     * In this function, we initialize some method for settings controller's variable
     * 
     * @return void
     *
     * @access public
     */
	public function __construct(){
		parent::__construct();
		/**
		 * Default timezone. You can change it based on your location.
		 */
		date_default_timezone_set("Asia/Jakarta");

		/**
		 * Setting the controller name to $this->controller variable.
		 */
		$this->setController();
		/**
		 * Setting the action name to $this->action variable.
		 */
		$this->setAction();
		/**
		 * Setting the controller name to $this->controller variable.
		 */
		$this->setView();
	}

	/**
     * Showing view with template layout
     * 
     * @param string 	$view View name on folder views
     * @param mix 		$data Data that will be shown on View
     * @param boolean	$bool If it's TRUE, the return will be string
     * 
     * @return void
     *
     * @access public
     */
	public function render($view, $data = array(), $bool = FALSE){
		$reflect = new ReflectionClass($this);
		$properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

		foreach($properties as $prop){
			$data[$prop->name] = $this->{$prop->name};
		}

		$data['pageContent'] = $this->load->view($view, $data, TRUE);
		if($bool){
			return $this->load->view($this->pageLayout, $data, TRUE);
		}else{
			$this->load->view($this->pageLayout, $data);
		}
	}
	
	/**
     * Showing view without template layout
     * 
     * @param string 	$view View name on folder views
     * @param mix 		$data Data that will be shown on View
     * @param boolean	$bool If it's TRUE, the return will be string
     * 
     * @return void
     *
     * @access public
     */
	public function renderPartial($view, $data = array(), $bool = FALSE){
		$reflect = new ReflectionClass($this);
		$properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

		foreach($properties as $prop){
			$data[$prop->name] = $this->{$prop->name};
		}

		if($bool){
			return $this->load->view($view,$data,TRUE);
		}else{
			$this->load->view($view,$data);
		}
	}
	
	/**
     * Set controller name
     * 
     * @param string $controller
     * 
     * @return void
     *
     * @access public
     */
	public function setController($controller = null){
		if($controller){
			$this->controller = $controller;
		}else{
			$this->controller = 
				$this->uri->segment($this->controllerSegment)?
					$this->uri->segment($this->controllerSegment):
						$this->getDefaultClass();
		}
	}

	/**
     * Set action name
     * 
     * @param string $action
     * 
     * @return void
     *
     * @access public
     */
	public function setAction($action = null){
		if($action){
			$this->action = $action;
		}else{
			$this->action = 
				$this->uri->segment($this->actionSegment)?
					$this->uri->segment($this->actionSegment):
						"index";
		}

	}
	
	/**
     * Set view name
     * 
     * @return void
     *
     * @access public
     */
	public function setView(){
		if($this->folder){
			$this->view = "{$this->folder}/{$this->controller}/{$this->action}";
		}else{
			$this->view = "{$this->controller}/{$this->action}";
		}
		
	}

	/**
     * Get default class name for current controller
     * 
     * @return string
     *
     * @access protected
     */
	protected function getDefaultClass(){
		preg_match_all('/((?:^|[A-Z])[a-z]+)/',get_class($this),$matches);
		$defaultClass = $this->extractClassName($matches[0]);
		return $defaultClass;
	}

	/**
     * Rename current class name
     * 
     * Example : 'UserStatusController' => 'user-status'
     * 
     * @param mix $arrClassName
     * 
     * @return string
     *
     * @access protected
     */
	protected function extractClassName($arrClassName = null){
		if($arrClassName){
			$newClass = "";
			foreach ($arrClassName as $i => $value) {
				if($i==0){
					$newClass .= strtolower($value);
				}else{
					if(strtolower($value) == "controller")
						break;
					$newClass .= "-".strtolower($value);
				}
			}
			return $newClass;
		}
	}

	/**
     * Generate pagination based on Codeigniter Pagination
     * 
     * @param string 	$baseUrl
     * @param integer 	$total
     * @param integer 	$limit
     * @param integer 	$uri
     * @param string 	$queryString
     * 
     * @return string
     *
     * @access protected
     */
	protected function paginate($baseUrl, $total, $limit, $uri, $queryString = ""){
		$this->load->library('pagination');

		$config['base_url'] = $baseUrl;
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri;

		$config['full_tag_open'] = '<ul class="pagination pull-right" style="margin:0">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '›';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '‹';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['query_string'] = $queryString;

		$this->pagination->initialize($config);

		return $this->pagination->create_links();
	}

	/**
     * Generate string for specific field
     * 
     * @param mix 	$keywords
     * 
     * @return string
     *
     * @access protected
     */
	protected function getSpecificWhere($keywords = array()){
		$where = "";

		$i = 0;
		foreach($keywords as $key=>$value){
			
			$filterValue = urldecode($value);

			if (strpos($filterValue,'%') !== false) {
				if($i == 0){
					$where .= "{$key} like '{$filterValue}'";
				}else{
					$where .= " AND {$key} like '{$filterValue}'";
				}
			} else {
				if($i == 0){
					$where .= "{$key} like '%{$filterValue}%'";
				}else{
					$where .= " AND {$key} like '%{$filterValue}%'";
				}
			}
			$i++;
		}

		return $where;
	}

	/**
     * Generate string for all fields on the table
     * 
     * @param string 	$keyword
     * 
     * @return string
     *
     * @access protected
     */
	protected function getWhere($keyword = null){
		if($keyword){
			$string = "(";
			$i=0;
			foreach(get_object_vars($this->Model) as $key => $value){
				if($i==0){
					$string .= "{$key} like '%{$keyword}%' ";
				}else{
					$string .= " OR {$key} like '%{$keyword}%' ";
				}
				$i++;
			}
			$string .=")";
			return $string;
		}
		return "";
	}
	
	/**
     * Generate thumb image
     * 
     * @param string 	$path
     * @param integer 	$width
     * @param integer 	$height
     * 
     * @return void
     *
     * @access protected
     */
	public function createThumb($path, $width = 400, $height = 400){
		$config['source_image']	= $path;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['thumb_marker'] = '_thumb';
		$config['width']	= $width;
		$config['height']	= $height;

		$this->image_lib->clear();

		$this->image_lib->initialize($config);
		
		if(!$this->image_lib->resize()){
			echo $this->image_lib->display_errors();
		}
	}

	/**
     * Show image that will be cropped
     * 
     * @param string 	$path
     * @param string 	$redirectUrl
     * @param boolean	$isThumb
     * @param integer 	$scaleWidth
     * @param integer 	$scaleHeight
     * 
     * @return string
     *
     * @access public
     */
	public function crop($path = NULL, $redirectUrl = NULL, $isThumb = FALSE, 
			$scaleWidth = 1, $scaleHeight = 1){
		
		if($path){
			$data['path'] = $path;
			$data['is_thumb'] = $isThumb;

			$data['scale_width'] = $scaleWidth;
			$data['scale_height'] = $scaleHeight;

			$data['redirect_url'] = $redirectUrl?$redirectUrl:site_url($controller);

			return $this->renderPartial("partial/crop", $data, TRUE);
		}
	}

	/**
     * Crop the image
     * 
     * @return void
     *
     * @access public
     */
	public function submitCrop(){
		
		if(isset($_POST['img_path'])){
			$imgPath = $_POST['img_path'];
			
			$x = $_POST['x'];
			$y = $_POST['y'];

			$xWidth = $_POST['x_width'];
			$yHeight = $_POST['y_height'];

			$imgWidth = $_POST['img_width'];
			$imgHeight = $_POST['img_height'];

			$scaleWidth = $_POST['scale_width'];
			$scaleHeight = $_POST['scale_height'];

			$isThumb = $_POST['is_thumb']==1?TRUE:FALSE;

			list($realWidth, $realHeight) = getimagesize($imgPath);
			
			$this->load->library('image_lib');

			//crop config
			$config['source_image'] = $imgPath;
			$config['x_axis'] = ($realWidth/$imgWidth) * $x;
			$config['y_axis'] = ($realHeight/$imgHeight) * $y;
			$config['width'] = ($realWidth/$imgWidth) * $xWidth;
			$config['height'] = ($realHeight/$imgHeight) * $yHeight;
			$config['maintain_ratio'] = FALSE;
			
			$this->image_lib->initialize($config); 
			
			if ( ! $this->image_lib->crop()){
				$this->msg['failed']['message'] = $this->image_lib->display_errors();
			}else{
				
				if($isThumb){
					$this->createThumb($imgPath);
				}

				$this->msg['success']['message'] = "Image has been successfully cropped";
			}
			echo json_encode($this->msg['success']);
			exit();
		}
	}
}