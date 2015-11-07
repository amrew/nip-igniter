<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @version    2.0
 * @link       http://nipstudio.com
 */
class AuthController extends Nip_Controller {
	
	/**
	 * Page title will be shown in the layout
	 *
	 * @var string
	 * @access public
	 */
	public $pageTitle = "Authentication";

	/**
	 * Layout file in the views folder
	 *
	 * @var string
	 * @access public
	 */
	public $pageLayout = "layouts/auth";
	
	/**
	 * Message for ajax response
	 *
	 * @var mix
	 * @access public
	 */
	public $msg = array(
			"success" => array(
				"status" => 1,
				"message" => '<span class="glyphicon glyphicon-ok-circle"></span> You\'ve successfully logged in',
				"param" => "alert alert-success"
			),
			"failed" => array(
				"status" => 2,
				"message" => '<span class="glyphicon glyphicon-remove-circle"></span> Failed',
				"param" => "alert alert-danger"
			),
			"invalid" => array(
				"status" => 3,
				"message" => '<span class="glyphicon glyphicon-ban-circle"></span> Invalid input',
				"param" => "alert alert-warning"
			),
		);

	/**
	 * Redirect url when success on login
	 *
	 * @var string
	 * @access public
	 */
	public $urlAfterLogin = "generator";
	
	/**
     * When you've already logged in and tried to access logout function,
     * you will be redirected to some URL ($urlAfterLogin)
     * 
     * @param string 	$method
     * @param mix 		$params
     *
     * @return void
     *
     * @access public
     */
	public function _remap($method, $params = array()) {
		if ($method!=="logout") {
			if ($this->session->userdata("user_id")) {

				redirect($this->urlAfterLogin);
				return;
			}
		}
		
		if (method_exists($this, $method)) {
			return call_user_func_array(array($this, $method), $params);
		}
		
		show_404();
		return;
	}

	public function __construct() {
		parent::__construct();
		
		/* Load  model */
		$this->load->model(array("Auth"));
		/* Load library */
		$this->load->library(array('encrypt'));
	}

	/**
     * Show login page when you aren't log in. 
     * 
     * @return void
     *
     * @access public
     */
	public function index() {
		$this->render("auth/index");
	}

	/**
     * Login process from the login page form
     * 
     * @return void
     *
     * @access public
     */
	public function login() {
		/**
	     * Show the login form if it isn't an ajax request.
	     * Prevent submitting process.
	     * Redirect to auth/index
	     */
		if (!$this->input->is_ajax_request()) {
			$this->session->set_flashdata('message', $this->msg['failed']);
			redirect("auth/index");
			return;
		}
			
		$userkey 	 = $this->input->post("userkey");
		$password 	 = $this->input->post("password");
		$encPassword = sha1($password);

		/**
		 * Check the user table with username
		 */
		$loginWithUsername = $this->Auth->login(array(
									'username' => $userkey,
									'password' => $encPassword,
									'status_id'=> 1
								)
							);

		/**
		 * Check the user table with email
		 */
		$loginWithEmail = $this->Auth->login(array(
									'email' => $userkey,
									'password' => $encPassword,
									'status_id'=> 1
								)
							);

		/**
		 * If one of them is correct then the login success.
		 */
		if ($loginWithUsername || $loginWithEmail) {
			
			$this->urlAfterLogin = $this->getUrlAfterLogin();

			$this->msg['success']['callback'] = site_url($this->urlAfterLogin);			
			echo json_encode($this->msg['success']);
		} else {
			echo json_encode($this->msg['failed']);
		}
	}

	public function signup(){
		$model = new User();
		
		if (isset($_POST["username"])) {
			$this->load->library(array('upload', 'encrypt'));
			
			$model->username = $this->input->post('username');
			$model->email = $this->input->post('email');
			$model->role_id = 2;
			$model->status_id = 1;

			$password    = $this->input->post("password");
			$repassword    = $this->input->post("repassword");

			if ($password != $repassword) {
				$this->msg['invalid']['message'] = "Password tidak sama.";
				echo json_encode($this->msg['invalid']);
				exit();
			}

			if (!empty($password)) {
				$password        = sha1($password);
				$model->password = $password;
			}

			if ($model->validate()) {
				if (empty($model->password)) {
					$this->msg['invalid']['message'] = "The Password field is required.";
					echo json_encode($this->msg['invalid']);
					exit();
				}

				if ($model->save()) {
					$this->msg['success']['message'] = '<span class="glyphicon glyphicon-ok-circle"></span> Sign up success. Please login first.';
					echo json_encode($this->msg['success']);
				} else {
					echo json_encode($this->msg['failed']);
				}

				exit();
			} else {
				$this->msg['invalid']['message'] = $model->messageString();
				echo json_encode($this->msg['invalid']);
				exit();
			}
		}
	}

	protected function getUrlAfterLogin(){
		$this->load->model('Menu');

		$menus = $this->Menu->all(array(
	        "where"=>array("privilege.role_id"=>$this->Auth->role()),
	        "order_by"=>"parent_menu_id asc, order asc",
	        "left_join" => array(
	            "privilege" => "privilege.menu_id = menu.id"
	        ),
	        "fields" => "menu.*, 
	                    privilege.view,
	                    privilege.create,
	                    privilege.update,"
	    ));

	    if(empty($menus)){
	    	return 'profile';
	    }

	    $url = "";
	    foreach($menus as $menu){
	    	if($menu->view == 1){
	    		$url = $menu->url;
	    	}else if($menu->create == 1){
	    		$url = $menu->url.'/edit';
	    	}

	    	if(!empty($menu->params)){
	    		$url = $url.'?'.$menu->params;
	    	}
	    	break;
	    }

	    return $url;
	}

	/**
     * Logout and then redirect to the login page
     * 
     * @return void
     *
     * @access public
     */
	public function logout(){
		$this->Auth->logout();
		redirect('auth');
	}

	/**
     * Show and submit the forgot form
     * 
     * @return void
     *
     * @access public
     */
	public function forgot() {
		$this->pageTitle = "Forgot Password.";

		/**
	     * Show the forgot form if it isn't an ajax request.
	     */
		if (!$this->input->is_ajax_request()) {
			$this->render("auth/forgot");
			return;
		}

		/**
	     * Check if email is empty or not
	     */
		if(!isset($_POST['email'])){
			$this->msg['invalid']['message'] = "Please don't let the email empty.";
			echo json_encode($this->msg['invalid']);
			return;
		}

		$email = $this->input->post("email");

		/**
	     * Check if email is empty or not
	     */
		if(empty($email)){
			$this->msg['invalid']['message'] = "Please don't let the email empty.";
			echo json_encode($this->msg['invalid']);
			return;
		}

		$user  = $this->User->first(array("email" => $email));

		/**
	     * Check if user exists or not
	     */
		if ($user === NULL) {
			$this->msg['invalid']['message'] = "The email doesn't exist.";
			echo json_encode($this->msg['invalid']);
			return;
		}

		/**
		 * Generate random string for activation_code
		 * This code is used for reset() function
		 */
		$user->activation_code = getRandomString(150);
		$user->save();

		$resetPasswordLink = '<a href="'.site_url("auth/reset/".$user->activation_code).'">Reset Password</a>';

		/**
	     * Get email template string
	     */
		$data["title"]   = "Reset Password.";
		$data["content"] = "You recently initiated a password reset for your password. 
							To complete the process, click the link below. 
							This link will expire one hours after this email was sent. <br> "
							. $resetPasswordLink;

		$emailTemplate = $this->load->view("auth/email", $data, TRUE);

		/**
	     * Send the email template to the user
	     */
		$this->load->library('email');

		$config['protocol'] = 'smtp';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = "html";

		/**
		 * In your hosting, you can remove this SMTP account
		 * This SMTP account is used for testing on localhost
		 */
		$config['smtp_host']= "smtp.mailgun.org";
		$config['smtp_user']= "postmaster@amrew.mailgun.org";
		$config['smtp_pass']= "6jrevn8pvi73";
		$config['smtp_port']= 587;
		$config['smtp_timeout']= 60;

		$this->email->initialize($config);

		$this->email->from('admin@nipstudio.com', 'Nip Stdio.');
		$this->email->to($user->email); 
		
		$this->email->subject('Reset Password.');
		$this->email->message($emailTemplate);	

		/**
	     * Response for ajax request
	     */
		if(!$this->email->send()){
			$this->msg['failed']['message'] = "Failed to send email verification.";
			echo json_encode($this->msg['failed']);
		}else{
			$this->msg['success']['message'] = "Please check your email to reset your password.";
			echo json_encode($this->msg['success']);
		}
	}

	/**
     * Show the reset form
     * 
     * @return void
     *
     * @access public
     */
	public function reset($string = ""){
		$this->pageTitle = "Reset Password.";

		/**
	     * Return blank page if the activation_code is empty
	     */
		if($string === ""){
			return;
		}

		/**
	     * Get user
	     */
		$where = "activation_code = '$string' AND updated > (NOW() - INTERVAL 1 HOUR)";
		$user  = $this->User->first($where);

		/**
	     * Show the reset form
	     */
		if ($user) {
			$data['activation_code'] = $string;
			$this->render("auth/reset", $data);
		} else {
			/**
		     * Failed if the links expired
		     */
			$this->session->set_flashdata('message', '<strong>Invalid Link</strong>. <br>We apologize, but we are unable to verify the link you used to access this page.');
			redirect("auth/forgot");
		}
	}

	/**
     * Reset process
     * 
     * @return void
     *
     * @access public
     */
	public function processReset(){
		if(	   !isset($_POST['activation_code']) 
			|| !isset($_POST['password']) 
			|| !isset($_POST['repassword'])
		){
			/**
		     * Failed if one of them is empty
		     */
			$this->msg['failed']['message'] = "Failed to process.";
			echo json_encode($this->msg['failed']);
			return;
		}

		/**
	     * Get all variables
	     */
		$activation_code = $this->input->post("activation_code");
		$password   	 = $this->input->post("password");
		$repassword 	 = $this->input->post("repassword");

		/**
	     * Check if the password is empty or not
	     */
		if (empty($password) || empty($repassword)) {
			$this->msg['invalid']['message'] = "Please don't let the password empty.";
			echo json_encode($this->msg['invalid']);
			return;
		}

		/**
	     * Check if the password is match to repassword field or not
	     */
		if (($password !== $repassword)) {
			$this->msg['invalid']['message'] = "The password didn't match.";
			echo json_encode($this->msg['invalid']);
			return;
		}

		/**
	     * Get user
	     */
		$user = $this->User->first("activation_code = '$activation_code'");

		/**
	     * Invalid if no user found.
	     */
		if($user === NULL){
			$this->msg['failed']['message'] = "<strong>Invalid Link</strong>. <br>We apologize, but we are unable to verify the link you used to access this page.";
			echo json_encode($this->msg['failed']);
			return;
		}

		/**
	     * save the new password to the database
	     */
		$user->activation_code = "";
		$user->password = sha1($password);
		
		if($user->save()){
			$this->msg['success']['message'] = "You've successfully reseted the password. Please login first.";
			echo json_encode($this->msg['success']);
			return;
		}

		$this->msg['failed']['message'] = "Failed. Application errors.";
		echo json_encode($this->msg['failed']);
		return;
	}

	/** Remove this function and the sql file when your web on production mode*/
	public function installExampleUser(){
		if(!isset($_POST['is_install'])){
			echo json_encode($this->msg['failed']);
		}

		$backup = file_get_contents('./nip-igniter.sql');
                
        $sql_clean = '';
        foreach (explode("\n", $backup) as $line) {
            
            if(isset($line[0]) && $line[0] != "#") {
                $sql_clean .= $line."\n";
            }
            
        }
        
        foreach (explode(";", $sql_clean) as $sql) {
            $sql = trim($sql);
            
            if($sql) {
                $this->db->query($sql);
            } 
        }

        echo json_encode($this->msg['success']);
	}
}