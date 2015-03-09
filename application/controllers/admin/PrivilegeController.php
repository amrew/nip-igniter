<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @version    2.0
 * @link       http://nipstudio.com
 */
class PrivilegeController extends Nip_Controller 
{
	
	/**
     * It will be show in the layout as title
     *
     * For example
     * <title>
     * 		<?php echo $pageTitle;?>
     * </title>
     *
     * @var string
     * @access public
     */
	public $pageTitle = "Privilege";

	/**
	 * Controller folder name
	 *
	 * @var string
	 * @access public
	 */
	public $folder = 'admin';

	/**
	 * Controller Segment on URL
	 *
	 * @var integer
	 * @access public
	 */
	protected $controllerSegment = 2;

	/**
	 * Action Segment on URL
	 *
	 * @var integer
	 * @access public
	 */
	protected $actionSegment = 3;
	/**
     * Message response for ajax request
     *
     * @var mix
     * @access public
     */
	public $msg = array(
			"success" => array(
				"status" => 1,
				"message" => "Success",
				"param" => "success"
			),
			"failed" => array(
				"status" => 2,
				"message" => "Failed",
				"param" => "danger"
			),
			"invalid" => array(
				"status" => 3,
				"message" => "Invalid",
				"param" => "warning"
			),
		);

	/**
     * This variable is an object for the main model in this controller
     *
     * $Model = new Privilege();
     * 
     * Usage :
     * $this->Model->first();
     * $this->Model->all();
     *
     * @var object
     * @access public
     */
	public $Model;

	/**
     * The default limit value for pagination
     *
     * @var integer
     * @access public
     */
	public $limit = 10;

	/**
     * In this function, we load some model for this controller 
     * and create new object for the $Model variable
     * 
     * @return void
     *
     * @access public
     */
    public function __construct() {
		parent::__construct();

		$this->load->model(
			array(
				'Privilege',
				'Menu',
				'Role',
				
			)
		);
		$this->Model = new Privilege();
	}

	/**
     * This action is used to show index, pagination and search page
     * 
     * @param integer 	$limit pagination limit
     * @param integer 	$offset
     *
     * @return void
     *
     * @access public
     */
	public function index() {
		if(isset($_POST['privilege'])){
			$role_id = $this->input->post("role_id");
			$menus = $this->input->post("menu");

			$this->Privilege->delete(array("role_id" => $role_id));
			foreach($menus as $key => $value){
				$object = new Privilege();
				$object->attr($value);

				$object->role_id = $role_id;
				$object->menu_id = $key;
				if($object->validate()){
					$object->save();
				}
			}

			$this->msg['success']['message'] = "Data berhasil ditambahkan.";
			echo json_encode($this->msg['success']);
			return;
		}

		$data['roles'] = $this->Role->all();
		$data["callback"]	= !empty($_SERVER['HTTP_REFERER'])
		   					 ? $_SERVER['HTTP_REFERER'] : site_url($this->pathController);

		$this->render("{$this->pathController}/settings", $data);
	}

	public function edit(){
		if(isset($_POST['role_id'])){
			$data['menus'] = $this->Menu->all();
			$data['role_id'] = $this->input->post("role_id");
			$this->renderPartial("{$this->pathController}/get-privilege", $data);
		}
	}

}