<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SYSTM {
	
	
	static function db_prefix(){
		$CI =& get_instance();
		$CI->load->database();
		return $CI->db->dbprefix;
	}
	
	static function generate_json($meta = null, $data = null){
		
		$default_meta = array(
					'meta' 	  => 404,
					'message' => 'Not Found',
					'details' => ''
				);
		$default_data = array();
		
		if( !is_null($meta) ){
			$default_meta = $meta;
		}
		if( !is_null($data) ){
			$default_data = $data;
		}
			
		$return =  array( 'meta'=>$default_meta, 'data'=>$default_data);
		return  json_encode($return);
	}

	
	/**
	 * CHECK IF LOGIN
	 */
	 
	static function unauthorized() {
		$meta = array(
				'meta'		=> 401,
				'message'	=> 'Your not authorized to access.',
				'details'	=> 'You have to login first.',
			);
	
		$generated_json = SYSTM::generate_json($meta, null);
		echo $generated_json;
	}
	
	static function check_if_login() {
		$CI =& get_instance();
		
		$return = 0;
		if ($CI->session->userdata('loggedin_userdata') == true) {
			$return = $CI->session->userdata('loggedin_userdata');
		}else{
			
			SYSTM::unauthorized();
		}
		return $return;
	
	}
		
		

}
