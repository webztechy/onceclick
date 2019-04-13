<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Load Language Suffixes
* @return
*/

class QUERY {
	
	
	static function record_list_join($table_conn = NULL, $table_conn2 = NULL,  $where = NULL, $order = NULL, $fieds = null, $limit = NULL)
	{	
		$CI =& get_instance();
		
		if (!is_null($fieds)){
			$CI->db->select($fieds);
		}
		
		$wh = $table_conn['tblname'].'.'.$table_conn['fld'];
		$wh2 = $table_conn2['tblname'].'.'.$table_conn2['fld'];
		
		$CI->db->from($table_conn['tblname']);
		$CI->db->join($table_conn2['tblname'], $wh.' = '.$wh2 );
		
		if (!is_null($where)){
			$inc=0;
			foreach($where as $kk=>$vv){
				if (!is_array($vv)){
					$CI->db->where($kk, $vv);
				}else{
					if ($inc==0){
						$CI->db->like($kk, $vv[0], $vv[1]);
					}else{
						if ( in_array('or_like', $vv) ){
							$CI->db->or_like($kk, $vv[0], $vv[1]);
						}else if ( in_array('or_where', $vv) ){
							$CI->db->or_where($kk, $vv[0], $vv[1]);
						}else{
							$CI->db->like($kk, $vv[0], $vv[1]);
						}
					}
					$inc++;
				}
			}
		}

		if (!is_null($order)){
			foreach($order as $kk=>$vv){
				$CI->db->order_by($kk, $vv);
			}
		}
		if (!is_null($limit)){
			$limit = explode(',', $limit);
			$limit = array_filter($limit);
			$limit = implode(',', $limit);
			list($start, $end) = explode(',', $limit);
			$CI->db->limit($start, $end);
		}
		
		$query = $CI->db->get();
		$row = $query->result();
		return $row;
	}
	
	static function record_list($table = NULL, $where = NULL, $fieds = null, $order = NULL, $limit = NULL, $extra_query = null, $where_in = null, $where_not_in = null)
	{	
		$CI =& get_instance();
		if (!is_null($fieds)){
			$CI->db->select($fieds);
		}
		if (!is_null($where)){
			$inc=0;
			foreach($where as $kk=>$vv){
				if (!is_array($vv)){
					$CI->db->where($kk, $vv);
				}else{
					if ($inc==0){
						$CI->db->like($kk, $vv[0], $vv[1]);
					}else{
						if ( in_array('or_like', $vv) ){
							$CI->db->or_like($kk, $vv[0], $vv[1]);
						}else if ( in_array('or_where', $vv) ){
							$CI->db->or_where($kk, $vv[0], $vv[1]);
						}else{
							$CI->db->like($kk, $vv[0], $vv[1]);
						}
					}
					$inc++;
				}
			}
		}

		if (!is_null($where_in)){
			if (count($where_in)==2){
				if (count($where_in[1])>0){
					$CI->db->where_in($where_in[0],$where_in[1]);
				}
			}else{
				foreach($where_in as $wh_in){
					if (count($wh_in[1])>0){
						$CI->db->where_in($wh_in[0],$wh_in[1]);
					}
				}
			}
		}
		
		if (!is_null($where_not_in)){
			if (count($where_not_in)==2){
				if (count($where_not_in[1])>0){
					$CI->db->where_not_in($where_not_in[0],$where_not_in[1]);
				}
			}else{
				foreach($where_not_in as $wh_not_in){
					if (count($wh_not_in[1])>0){
						$CI->db->where_not_in($wh_not_in[0],$wh_not_in[1]);
					}
				}
			}
		}
		
		
		if (!is_null($extra_query)){
			if (is_array($extra_query)){
				foreach($extra_query as $query=>$value){
					$CI->db->$query($value);
				}					
			}
		}
		
		if (!is_null($order)){
			foreach($order as $kk=>$vv){
				$CI->db->order_by($kk, $vv);
			}
		}
		if (!is_null($limit)){
			list($start, $end) = explode(',', $limit);
			$CI->db->limit($end, $start);
		}
		
		$query = $CI->db->get($table);
		$row = $query->result();
		return $row;
	}

	
	

	static function record_get($table = NULL, $where = NULL, $fieds = null, $order = NULL)
	{	
		$CI =& get_instance();
		if (!is_null($fieds)){
			$CI->db->select($fieds);
		}
		/*if (!is_null($where)){
			foreach($where as $kk=>$vv){
				$CI->db->where($kk, $vv);
			}
		}*/
		
		if (!is_null($where)){
			$inc=0;
			foreach($where as $kk=>$vv){
				if (!is_array($vv)){
					$CI->db->where($kk, $vv);
				}else{
					if ($inc==0){
						$CI->db->like($kk, $vv[0], $vv[1]);
					}else{
						if ( in_array('or_like', $vv) ){
							$CI->db->or_like($kk, $vv[0], $vv[1]);
						}else if ( in_array('or_where', $vv) ){
							$CI->db->or_where($kk, $vv[0], $vv[1]);
						}else{
							$CI->db->like($kk, $vv[0], $vv[1]);
						}
					}
					$inc++;
				}
			}
		}
		
		if (!is_null($order)){
			foreach($order as $kk=>$vv){
				$CI->db->order_by($kk, $vv);
			}
		}
		
		$query = $CI->db->get($table);
		$row = $query->row();
		return $row;
	}
	
	static function record_add($table = NULL, $data = NULL)
	{		
		$CI =& get_instance();
		$res = $CI->db->insert($table, $data);
		if($res):
			return $CI->db->insert_id();
		else :
			return false;
		endif;
		
	}
	
	static function record_add_batch($table = NULL, $data = NULL)
	{		
		$CI =& get_instance();
		$res = $CI->db->insert_batch($table, $data);
		if($res):
			return true;
		else :
			return false;
		endif;
		
	}
	
	
	static function record_edit($table = NULL, $where = NULL, $data = NULL)
	{	
		$CI =& get_instance();
		if (!is_null($where)){
			foreach($where as $kk=>$vv){
				$CI->db->where($kk, $vv);
			}
		}
		$res = $CI->db->update($table, $data);
		if($res):
			return true;
		else :
			return false;
		endif;
		
	}
	
	static function record_delete($table = NULL, $where = NULL)
	{
		$CI =& get_instance();
		if (!is_null($where)){
			foreach($where as $kk=>$vv){
				$CI->db->where($kk, $vv);
			}
		}
		$res = $CI->db->delete($table); 
		if($res):
			return true;
		else :
			return false;
		endif;
	}
	
	
	
	/** COUNTING  **/
	static function record_list_count($table = NULL, $where = NULL, $group_by = null, $extra_query = null, $where_in = null, $where_not_in = null)
	{	
		$CI =& get_instance();
		if (!is_null($where)){
			$inc=0;
			foreach($where as $kk=>$vv){
				if (!is_array($vv)){
					$CI->db->where($kk, $vv);
				}else{
					if ($inc==0){
						$CI->db->like($kk, $vv[0], $vv[1]);
					}else{
						if ( in_array('or_like', $vv) ){
							$CI->db->or_like($kk, $vv[0], $vv[1]);
						}else if ( in_array('or_where', $vv) ){
							$CI->db->or_where($kk, $vv[0], $vv[1]);
						}else{
							$CI->db->like($kk, $vv[0], $vv[1]);
						}
					}
					$inc++;
				}
			}
		}
		
		
		if (!is_null($where_in)){
			if (count($where_in)==2){
				if (count($where_in[1])>0){
					$CI->db->where_in($where_in[0],$where_in[1]);
				}
			}else{
				foreach($where_in as $wh_in){
					if (count($wh_in[1])>0){
						$CI->db->where_in($wh_in[0],$wh_in[1]);
					}
				}
			}
		}
		
		if (!is_null($where_not_in)){
			if (count($where_not_in)==2){
				if (count($where_not_in[1])>0){
					$CI->db->where_not_in($where_not_in[0],$where_not_in[1]);
				}
			}else{
				foreach($where_not_in as $wh_not_in){
					if (count($wh_not_in[1])>0){
						$CI->db->where_not_in($wh_not_in[0],$wh_not_in[1]);
					}
				}
			}
		}
		
		
		if (!is_null($extra_query)){
			if (is_array($extra_query)){
				foreach($extra_query as $query=>$value){
					$CI->db->$query($value);
				}					
			}
		}
		
		
		if (!is_null($group_by)){
			$CI->db->group_by($group_by);
		}
	
		$query = $CI->db->get($table);
		$row = $query->num_rows();
		return $row;
	}
	
	
	
	
	/** SUM  **/
	static function record_list_join_sum($table_conn = NULL, $table_conn2 = NULL,  $where = NULL, $field_name = null)
	{	
		$row = 0;
		
		if (!is_null($field_name)){
			$CI =& get_instance();
			$CI->db->select_sum($field_name);
		
			
			$wh = $table_conn['tblname'].'.'.$table_conn['fld'];
			$wh2 = $table_conn2['tblname'].'.'.$table_conn2['fld'];
			
			$CI->db->from($table_conn['tblname']);
			$CI->db->join($table_conn2['tblname'], $wh.' = '.$wh2 );
			
			if (!is_null($where)){
				foreach($where as $kk=>$vv){
					$CI->db->where($kk, $vv);
				}
			}
			
			$query = $CI->db->get();
			$row = $query->result();
		}
		return $row;
	}
	
	static function record_list_sum($table = NULL, $where = NULL, $field_name = null)
	{	
		$row = 0;
		if ( !is_null($field_name) ){
			$CI =& get_instance();
			
			$CI->db->select_sum($field_name);
			
			if (!is_null($where)){
				/*foreach($where as $kk=>$vv){
					$CI->db->where($kk, $vv);
				}*/
				$inc=0;
				foreach($where as $kk=>$vv){
					if (!is_array($vv)){
						$CI->db->where($kk, $vv);
					}else{
						if ($inc==0){
							$CI->db->like($kk, $vv[0], $vv[1]);
						}else{
							if ( in_array('or_like', $vv) ){
								$CI->db->or_like($kk, $vv[0], $vv[1]);
							}else if ( in_array('or_where', $vv) ){
								$CI->db->or_where($kk, $vv[0], $vv[1]);
							}else{
								$CI->db->like($kk, $vv[0], $vv[1]);
							}
						}
						$inc++;
						
					}
				}

			}
			$query = $CI->db->get($table);
			$row = $query->result();
		}
		return $row;
	}
	
	static function sql_direct($table = null, $where = null, $fields = null){
		
		$row = 0;
		$sql = 'SELECT ';
		$fld = '*';
		$wh = '';

		if (!is_null($table)){
		$CI =& get_instance();	
			if(!is_null($where)){
				foreach( $where as $key=>$val){ $wh .= $key.' '.$val.' '; }
			}
			if(!is_null($fields)){ $fld = implode(',', $fields); }
			$table = ' FROM '.$table;
			$sql = $sql.' '.$fld.' '.$table.' '.$wh;
			
			$query = $CI->db->query($sql);
			$row = $query->result();
		}
		return $row;
	}
	
}