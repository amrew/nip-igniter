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
	 * Path to controller name include folder
	 *
	 * @var string
	 * @access public
	 */
	public $pathController;
	
	/**
	 * Url tambahan yang berupa parameter GET
	 *
	 * @var string
	 * @access public
	 */
	public $queryString = "";

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

				$message = "You have no privilege to access it!";

				if ($this->input->is_ajax_request()) {
					echo json_encode(
							array(
								"status" => 404, 
								"message"=> $message
							)
						);
					return;
				}else{
					$data["callback"] = !empty($_SERVER['HTTP_REFERER'])
		   							   ? $_SERVER['HTTP_REFERER'] : site_url($this->controller);
		   			$data["message"]  = $message;
					$this->render("layouts/partial/error.php", $data);
					return;
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

		$this->queryString = ($_SERVER['QUERY_STRING'] != "") ? "?".$_SERVER['QUERY_STRING'] : "";
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
		$this->beforeRender();

		$reflect 	= new ReflectionClass($this);
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
		$this->beforeRender();

		$reflect 	= new ReflectionClass($this);
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

	public function beforeRender(){
		if(!empty($this->paramString)) {
			$this->paramString = "?".$this->paramString;
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
			$controller = $this->router->fetch_class();
			$controller = getStrippedClass($controller);

			$this->controller = $controller;
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
			$this->action = $this->router->fetch_method();
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
			$this->pathController = "{$this->folder}/{$this->controller}";
		}else{
			$this->view = "{$this->controller}/{$this->action}";
			$this->pathController = "{$this->controller}";
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
	protected function paginate($baseUrl, $total, $limit, $offset = 0){
		$this->load->library('pagination');

		$queryString = $this->queryString;

		$config['base_url'] 	= $baseUrl;
		$config['total_rows'] 	= $total;
		$config['per_page'] 	= $limit;
		
		$config['full_tag_open'] 	= '<ul class="pagination pull-right" style="margin:0">';
		$config['full_tag_close'] 	= '</ul>';

		$config['first_link'] 		= '&laquo;';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';

		$config['last_link'] 		= '&raquo;';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';

		$config['next_link'] 		= '›';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';

		$config['prev_link'] 		= '‹';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';

		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';

		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';

		$config['suffix']			= $queryString;
		$config['offset'] 			= $offset;

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

	protected function getDefaultWhere(){
		$query_string = isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
		parse_str($query_string, $on_address_bar);

		parse_str($this->paramString, $array);

		$where = array();
		foreach($array as $key => $val){
			$where[$key] = isset($on_address_bar[$key])?$on_address_bar[$key]:"";
		}

		return $where;
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
		$config['source_image']		= $path;
		$config['create_thumb'] 	= TRUE;
		$config['maintain_ratio'] 	= TRUE;
		$config['thumb_marker'] 	= '_thumb';
		$config['width']			= $width;
		$config['height']			= $height;

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
			$data['path'] 			= $path;
			$data['is_thumb'] 		= $isThumb;

			$data['scale_width'] 	= $scaleWidth;
			$data['scale_height'] 	= $scaleHeight;

			$data['redirect_url'] 	= $redirectUrl?$redirectUrl:site_url($this->pathController);

			return $this->renderPartial("layouts/partial/crop", $data, TRUE);
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

		$is_skip = isset($_POST['is_skip'])?$_POST['is_skip']:false;

		if($is_skip == "true"){
			$imgPath = $_POST['img_path'];
			$dirname = dirname($imgPath);
			$basename = basename($imgPath);
			list($raw, $ext) = explode(".", $basename);

			$newfile = $dirname.'/'. $raw . "_thumb" . "." . $ext;
			if (!copy($imgPath, $newfile)) {

				$this->msg['failed']['message'] = "Failed to skip this section.";
				echo json_encode($this->msg['failed']);
				exit();

			} else {
				$this->msg['success']['message'] = "Image has been successfully cropped";
			}

			echo json_encode($this->msg['success']);
			exit();
		}
		
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
				echo json_encode($this->msg['failed']);
				exit();
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