<?php
 class shop_model extends CI_Model 
{
	function get_shop($product_ids = array())
	{
		$admin = $this->session->userdata('user_id');
		$this->db->select('business_id');
		$business = $this->db->where('user_id', $admin)->get('ci_businesses')->row();
		$business_id = (!empty($business)) ? $business->business_id : null ;

		$shops = $this->db->where('business', $business_id)->get('ci_shops');
		return $shops;
	}
	
	function shop_details($shop_id = ''){
		$shop = $this->db->where('payment_shop_id', $shop_id)->get('ci_shops')->row();
		return $shop;
	}
	
	function get_select_option($table,$id,$name,$selected=0){
		$this->db->where('owner', $this->session->userdata('user_id'));
		$query = $this->db->get($table);
		$select = '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
				$selected_option = ($selected==$row[$id]) ? ' selected="selected" ':' ';
				$select.='<option value="'.$row[$id].'" '. $selected_option.'>'.trim(strtoupper($row[$name])).'</option>';
			}
		}
		return $select;
	}
	
	function get_business_shops($selected = '', $id = 'shop_id', $name= 'shop_name'){
		$business = get_business_config();
		$business_id = (!empty($business)) ? $business->business_id : null ;
	
		$query = $this->db->where('business', $business_id)->get('ci_shops');
		$select = '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
				$selected_option = ($selected==$row[$id]) ? ' selected="selected" ':' ';
				$select.='<option value="'.$row[$id].'" '. $selected_option.'>'.trim(strtoupper($row[$name])).'</option>';
			}
		}
		return $select;
	}
	
	function set_manager($shop_id, $user_id){
		$details = array('manager' => $user_id);
		$this->db->where('shop_id', $shop_id)->update('ci_shops', $details);
		
	}
	function get_shops(){
		$user_level = $this->session->userdata('level');
		$user_id = $this->session->userdata('user_id');
		$business = get_business_config();
		$business_id = (!empty($business)) ? $business->business_id : null ;
	
		if($user_level == 1) :
		$query = $this->db->where('business', $business_id)->get('ci_shops');
		else :
		$query = $this->db->where('manager', $user_id)->get('ci_shops');
		endif;
	
		$shops = array();
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
				array_push($shops, $row['shop_id']);
			}
		}
		return $shops;
	}
	
	function allowed_toview($shop_id = 0){
		$shops = $this->get_shops();
		if(in_array($shop_id,$shops)){
			return true;
		}
		else{
			return false;
		}
	}
		
}
