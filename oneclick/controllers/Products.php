<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	
	var $meta = 404;
	var $message = 'Not Found';
	var $details = '';
	var $current_date = '';

	
	public function __construct() {
		parent::__construct();
		
		$this->current_date = date('Y-m-d H:i:s');
		
	}
	
	
	public function all() {
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==2){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		
		
		$meta = 200;
		$message = 'Ok';
		$data = array();
		
		$fields = 'product_id,product_barcode,product_name,product_cost,product_vat,product_created_date';
		$product_list = QUERY::record_list('products', array('product_id >'=>0), $fields );
		
		if(!$product_list){
			$details = 'Unable to list all products.';
		}else{
			foreach($product_list as $row){
				$det = array(
							'product_id' 		   => $row->product_id,
							'product_barcode'	   => $row->product_barcode,
							'product_name' 		   => $row->product_name,
							'product_cost'		   => $row->product_cost,
							'product_vat'		   => $row->product_vat,
							'product_created_date' => $row->product_created_date
						);
				$data[] = $det;
			}
			
			$details = 'List of all products.';
		}
		
		
		$meta = array(
					'meta'		=> $meta,
					'message'	=> $message,
					'details'	=> $details,
				);
		
		$generated_json = SYSTM::generate_json($meta, $data);
		echo $generated_json;
		
	}
	
	public function add() {
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==2){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		$_GET_DATA = $_GET;
		
		// barcode,name,cost,vat
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('barcode','name','cost','vat');
		foreach($fields_array as $key_val){
			if ( array_key_exists($key_val, $_GET_DATA ) ){
				if (($key = array_search($key_val, $fields_array)) !== false) {
					unset($fields_array[$key]);
				}
			}
		}
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		
		$allowed_vat = array(6,21);
		
		if ( count($fields_array) > 0 ){
			$missing_fields = implode(', ', $fields_array);
			$meta = 405; //406
			$message = 'Not Acceptable';
			$details = 'Missing Fields: '.$missing_fields;
			
		}else{
		
			$meta = 200;
			$message = 'Ok';
			$details = 'Product barcode already exist.';
			
			if ( !in_array($vat, $allowed_vat) ){
				$details = 'Product vat should be 6% or 21%.';
			}else{
				$barcode_exists = 0;
				$where = array('product_barcode'=>$barcode);
				$product_detail = QUERY::record_get('products', $where, 'product_id');
				if ($product_detail){
					$barcode_exists = 1;
				}
					
				
				if ($barcode_exists==0){
					$product_data = array(
								'product_barcode' 		=> 	$barcode,
								'product_name' 			=>  $name,	
								'product_cost'		    =>  $cost,	
								'product_vat' 		    => 	$vat, 	
								'product_created_date'  => 	$this->current_date, 	
							  );
					$product_id = QUERY::record_add('products', $product_data);
					if (!$product_id){
						$details = 'Could not insert record.';
					}else{
						$meta = 201;
						$message = 'Created';
						$details = 'Products has been added. (id:'.$product_id.')';
					}
				}
			}
				
		}
		
		$meta = array(
					'meta'		=> $meta,
					'message'	=> $message,
					'details'	=> $details,
				);
		
		$generated_json = SYSTM::generate_json($meta, null);
		echo $generated_json;
	}
	
	
	public function detail(){
		
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==2){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		$_GET_DATA = $_GET;
		$data = array();
		
		// barcode
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('barcode');
		foreach($fields_array as $key_val){
			if ( array_key_exists($key_val, $_GET_DATA ) ){
				if (($key = array_search($key_val, $fields_array)) !== false) {
					unset($fields_array[$key]);
				}
			}
		}
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		
		
		if ( count($fields_array) > 0 ){
			$missing_fields = implode(', ', $fields_array);
			$meta = 405; //406
			$message = 'Not Acceptable';
			$details = 'Missing Fields: '.$missing_fields;
			
		}else{
			
			$meta = 200;
			$message = 'Ok';
			$details = 'Product does not exist.';
			
			
			$where = array('product_barcode'=>$barcode);
			$fields = 'product_id,product_barcode,product_name,product_cost,product_vat,product_created_date';
			$product_detail = QUERY::record_get('products', $where, $fields);
			if ($product_detail){
				$message = 'Ok';
				$details = 'Product Details.';
				
				$data = array(
							'product_id' 		   => $product_detail->product_id,
							'product_barcode'	   => $product_detail->product_barcode,
							'product_name' 		   => $product_detail->product_name,
							'product_cost'		   => $product_detail->product_cost,
							'product_vat'		   => $product_detail->product_vat,
							'product_created_date' => $product_detail->product_created_date
						);
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



/* 
'meta' 	  => 404,
'message' => 'Not Found',
'details' => ''
*/