<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipts extends CI_Controller {


	var $meta = 404;
	var $message = 'Not Found';
	var $details = '';
	var $current_date = '';

	
	public function __construct() {
		parent::__construct();
		
		$this->current_date = date('Y-m-d H:i:s');
	}
	
	
	public function add() {
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==1){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		
		$_GET_DATA = $_GET;
		
		// code
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('code');
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
			$details = 'Receipt barcode already exist.';
			
			
			$code_exists = 0;
			$where = array('receipt_code'=>$code);
			$receipt_detail = QUERY::record_get('receipts', $where, 'receipt_id');
			if ($receipt_detail){
				$code_exists = 1;
			}
			

			if ($code_exists==0){
				$receipt_data = array(
							'receipt_code' 				=> 	$code,
							'receipt_created_date' 		=> 	$this->current_date
						  );
				$receipt_id = QUERY::record_add('receipts', $receipt_data);
				if (!$receipt_id){
					$details = 'Could not insert record.';
				}else{
					$meta = 201;
					$message = 'Created';
					$details = 'Products has been added. (id:'.$receipt_id.')';
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
	
	
	public function add_product() {
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==1){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		
		$_GET_DATA = $_GET;
		
		// code
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('code','barcode');
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
			$details = '';
			
			$counter = 0;
			
			$code_exists = 0;
			$where = array('receipt_code'=>$code);
			$receipt_detail = QUERY::record_get('receipts', $where, 'receipt_id,receipt_products');
			if ($receipt_detail){
				$code_exists = 1;
				$counter++;
			}
			
			$barcode_exists = 0;
			$where = array('product_barcode'=>$barcode);
			$product_detail = QUERY::record_get('products', $where, 'product_id,product_barcode,product_name,product_cost,product_vat');
			if ($product_detail){
				$barcode_exists = 1;
				$counter++;
			}
				
			if ($counter==2){
				
				$receipt_id = $receipt_detail->receipt_id;
				
				$receipt_products_array = array();
				$receipt_products = $receipt_detail->receipt_products;
				if(!empty($receipt_products)){
					$receipt_products_array = unserialize($receipt_products);
				}
				
				$product_id = $product_detail->product_id;
				$receipt_products_array[] = array(
												'product_id' 		   => $product_id,
												'product_barcode'	   => $product_detail->product_barcode,
												'product_name' 		   => $product_detail->product_name,
												'product_cost'		   => $product_detail->product_cost,
												'product_vat'		   => $product_detail->product_vat,
												'product_time'		   => $this->current_date
											);
							
				$receipt_data = array(
									'receipt_products' => serialize($receipt_products_array),
									'receipt_modified_date' => $this->current_date
								);	
								
				$where = array('receipt_id'=>$receipt_id);
				$result = QUERY::record_edit('receipts', $where, $receipt_data);
				if (!$result){
					$details = 'Could not insert product in the receipt.';
				}else{
					$meta = 201;
					$message = 'Product has been added.';
					$details = 'Added product to receipt code '.$code.'.';
				}
				
			}else{
				
				if ($code_exists==1 && $barcode_exists==0){
					$details = 'Product barcode is not exist.';
				}else if ($barcode_exists==1 && $code_exists==0){
					$details = 'Receipt code is not exist.';
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
	
	
	public function price_product_last(){
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==1){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		
		$_GET_DATA = $_GET;
		
		// code
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('code','price');
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
			$details = 'Receipt code is not exist.';
			
			$where = array('receipt_code'=>$code);
			$receipt_detail = QUERY::record_get('receipts', $where, 'receipt_id,receipt_products');
			if ($receipt_detail){
				$receipt_id = $receipt_detail->receipt_id;
				
				$receipt_products_array = array();
				$receipt_products = $receipt_detail->receipt_products;
				if(!empty($receipt_products)){
					$receipt_products_array = unserialize($receipt_products);

					$last_key = count($receipt_products_array)-1;
					$last_item = $receipt_products_array[$last_key];
					$last_item['product_cost'] = $price;
					$receipt_products_array[$last_key] = $last_item;
					
					
					$receipt_data = array(
										'receipt_products' => serialize($receipt_products_array),
										'receipt_modified_date' => $this->current_date
									);	
									
					$where = array('receipt_id'=>$receipt_id);
					$result = QUERY::record_edit('receipts', $where, $receipt_data);
					if (!$result){
						$details = 'Could not update product in the receipt.';
					}else{
						$meta = 201;
						$message = 'Updated';
						$details = 'Updated last product price price to receipt code '.$code.'.';
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
	
	public function finish(){
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==1){
				SYSTM::unauthorized();
				return false;
			}
		}
		
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		
		$_GET_DATA = $_GET;
		
		// code
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('code');
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
			$details = 'Receipt code is not exist.';
			
			
			$where = array('receipt_code'=>$code);
			$receipt_detail = QUERY::record_get('receipts', $where, 'receipt_id,receipt_products');
			if ($receipt_detail){
				$receipt_id = $receipt_detail->receipt_id;
				
					$receipt_data = array(
										'receipt_status' => 1,
										'receipt_modified_date' => $this->current_date
									);	
									
					$where = array('receipt_id'=>$receipt_id);
					$result = QUERY::record_edit('receipts', $where, $receipt_data);
					if (!$result){
						$details = 'Could not update product in the receipt.';
					}else{
						$meta = 201;
						$message = 'Updated';
						$details = 'Receipt '.$code.' has been marked as finished.';
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
		
		$uri_segment = $this->uri->segment(3);
		
		$return = SYSTM::check_if_login();
		if (!$return){ return false; }
		else{
			$user_role_id = $return['user_role_id'];
			if ($user_role_id==1){
				//SYSTM::unauthorized();
				//return false;
			}
		}
		
		$meta = $this->meta;
		$message = $this->message;
		$details = $this->details;
		$data = null;
		
		$_GET_DATA = $_GET;
		
		// code
		foreach($_GET_DATA as $kk=>$vv){ $$kk = $vv; }
		
		$fields_array = array('code');
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
			$details = 'Receipt code is not exist.';
			
			
			$where = array('receipt_code'=>$code);
			$receipt_detail = QUERY::record_get('receipts', $where, 'receipt_id,receipt_products,receipt_code,receipt_status,receipt_created_date,receipt_modified_date');
			if ($receipt_detail){
				$details = 'Receipt detail details.';
				
				$receipt_id = $receipt_detail->receipt_id;
				$receipt_products = $receipt_detail->receipt_products;
				
				$receipt_products_array = array();
				if (!empty($receipt_products)){
					$receipt_products_array = unserialize($receipt_products);
				}
				//print_r($receipt_products_array);
				
				$product_array = array();
				$product_total_all = 0;
				foreach($receipt_products_array as $row){
					$product_id = $row['product_id'];
					$product_barcode = $row['product_barcode'];
					$product_name = $row['product_name'];
					$product_cost = $row['product_cost'];
					$product_vat = $row['product_vat'];
					
					$product_total = ($product_vat/100)+$product_cost;
					$product_total_all = $product_total_all + $product_total;
					
					
						$product_array[$product_id][] = array(
															'product_id' => $product_id,
															'product_barcode' => $product_barcode,
															'product_name' => $product_name,
															'product_cost' => $product_cost,
															'product_vat' => $product_vat,
															'product_total' => $product_total
														);
														
				}
				
				$product_total_all_formatted = number_format($product_total_all, 2);
				$data = array(
							'receipt_id' => $receipt_id,
							'receipt_code' => $receipt_detail->receipt_code,
							'receipt_status' => $receipt_detail->receipt_status,
							'receipt_created_date' => $receipt_detail->receipt_created_date,
							'receipt_modified_date' => $receipt_detail->receipt_modified_date,
							'receipt_total' => $product_total_all_formatted,
							'product_items' => $product_array
						);
						
						$receipt_total_discounted = $product_total_all;
						$product_items_discounted = array();
						foreach($product_array as $row){
							if (count($row)>=3){
								$product_items_discounted[$row[0]['product_id']] = $row[0];
							}
						}
						
						if (count($product_items_discounted)>0){
							foreach($product_items_discounted as $row){
								$receipt_total_discounted = $receipt_total_discounted - $row['product_total'];
							}	
						}
						
						
						if ($uri_segment=='add-discount'){
							$data['product_items_discounted']  = $product_items_discounted;
							$data['receipt_total_discounted']  = $receipt_total_discounted;
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
