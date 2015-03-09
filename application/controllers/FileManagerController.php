<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @version    2.0
 * @link       http://nipstudio.com
 */
class FileManagerController extends Nip_Controller {
	
	/**
	 * Page title will be shown in the layout
	 *
	 * @var string
	 * @access public
	 */
	public $pageTitle = "File Manager";

	/**
	 * Layout file in the views folder
	 *
	 * @var string
	 * @access public
	 */
	public $pageLayout = "layouts/main3";
	
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

	public function __construct(){
		parent::__construct();
		$this->load->model("Auth");
	}

	public function index(){
		if(isset($_GET['getpartial'])){
			$this->renderPartial("layouts/partial/elfinder");
		}else{
			$this->render("file-manager/index");
		}
	}
}