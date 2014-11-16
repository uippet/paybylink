<?php
 class Api_model extends CI_Model 
{
	
	function get_apis(){
		$shops = $this->get_business_shops();
		$this->db->join('ci_shops', 'ci_shops.shop_id = api.shop_id');
		if(!empty($shops)) :
		$this->db->where_in('api.shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif;
		$apis = $this->db->get('api');
		return $apis;
	}
	function get_api($api_id = 0){
		$api = $this->db->where('api_id', $api_id)->get('api')->row();
		return $api;
	}
	function get_business_shops(){
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
	function save_api($api_details = array(), $api_id = 0){
		
		if($api_id == 0)  : 
			$this->db->insert('api', $api_details);
		else :
			$this->db->where('api_id', $api_id);
			$this->db->update('api', $api_details);
		
		endif;
	}
	function delete($api_id = 0){
		$this->db->where('api_id', $api_id)->delete('api');
	}

	function apifrm($apikey = ''){
		$api = $this->db->where('api_key', $apikey)
						->get('api')
						->row();
		return $api;
	}
}
