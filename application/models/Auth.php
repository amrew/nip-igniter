<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Nip_Model {

	/** 
	 * Model for Authentication
	 */
	public $model = "User";

	protected $user;

	public function __construct($options = array()){
		parent::__construct($options);

		$this->load->model("User");
	}

	public function check(){
		if ($this->session->userdata('user_id')) {
			return TRUE;
		}
		return FALSE;
	}

	public function login($data = array()) {
		
		$result  = $this->{$this->model}->first($data);
		$primary = $this->{$this->model}->getPrimary();

		if ($result) {
			$this->session->set_userdata('user_id', $result->{$primary});
			$this->session->set_userdata('role_id', $result->role_id);
			
			return TRUE;
		}

		return FALSE;
	}

	public function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('role_id');

		return TRUE;
	}

	public function user() {
		if ($this->check()) {

			if (empty($this->user)) {

				$user_id = $this->session->userdata('user_id');
				
				$user 		= $this->{$this->model}->first($user_id);
				$this->user = $user;
				
				return $user;
			} else {

				return $this->user;
			}
		}

		return NULL;
	}
	
	public function primary() {
		$user = $this->user();

		if ($user) {
			$primary = $user->getPrimary();
			
			return $user->{$primary};
		}

		return FALSE;
	}
	
	public function role() {
		$user = $this->user();
		
		if ($user) {
			return $user->role_id;
		}

		return FALSE;
	}
}