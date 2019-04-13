<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	var $meta = 404;
	var $message = 'Not Found';
	var $details = '';
	var $current_date = '';

	
	public function __construct() {
		parent::__construct();
		
		$this->current_date = date('Y-m-d H:i:s');
	}
	
	public function index() {
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		$data = null;
		
		$_GET_DATA = $_GET;
		
		// username,password
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('username','password');
		foreach($fields_array as $key_val){
			if ( array_key_exists($key_val, $_GET_DATA ) ){
				if (($key = array_search($key_val, $fields_array)) !== false) {
					unset($fields_array[$key]);
				}
			}
		}
		
		if ( count($fields_array) > 0 ){
			$missing_fields = implode(', ', $fields_array);
			$meta = 405; //406
			$message = 'Not Acceptable';
			$details = 'Missing Fields: '.$missing_fields;
			
		}else{
			
			$meta = 200;
			$message = 'Ok';
			$details = 'User does not exist.';
				
				$password = md5($password);
				$where = array('user_name'=>$username);
				$user_detail = QUERY::record_get('users', $where, 'user_id,user_password,user_fname,user_lname,user_role_id,user_email,user_contact');
				if ($user_detail){
					$user_password = $user_detail->user_password;
					
					if ($user_password==$password){
						$details = 'User has been authorized to access.';
						$loggedin_userdata = array(
												'user_fname' => $user_detail->user_fname,
												'user_lname' => $user_detail->user_lname,
												'user_role_id' => $user_detail->user_role_id,
												'user_email' => $user_detail->user_email,
												'user_contact' => $user_detail->user_contact,
												'login_time' => $this->current_date
											);
								
						
							$userdata = array(
											'loggedin_userdata' => $loggedin_userdata
										);
							
							$this->session->set_userdata($userdata);
							
					}else{
						$details = 'Username and password did not matched.';
					}
				}
		}
		
		$meta = array(
					'meta'		=> $meta,
					'message'	=> $message,
					'details'	=> $details,
				);
		
		$generated_json = SYSTM::generate_json($meta, $data);
		echo $generated_json;
		
	}
}
