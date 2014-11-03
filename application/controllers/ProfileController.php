<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @version    2.0
 * @link       http://nipstudio.com
 */
class ProfileController extends Nip_Controller {
	
	/**
	 * Page title will be shown in the layout
	 *
	 * @var string
	 * @access public
	 */
	public $pageTitle = "Profile Page";

	/**
	 * Layout file in the views folder
	 *
	 * @var string
	 * @access public
	 */
	public $pageLayout = "layouts/main";
	
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
	 * Action rules for user
	 *
	 * @var mix
	 * @access public
	 */
	protected $rules = array(
		'*' => array(),
		'1' => array("*"),  //admin
		'2' => array("*") 	//member
	);

	public function __construct(){
		parent::__construct();
		$this->load->model("Auth");
	}

	public function index(){
		$data['model'] = $this->Auth->user();
		$this->render($this->view, $data);
	}

}