<?php
 class Payment_page_model extends CI_Model 
{
	function get_pages(){
		$shops = $this->get_shops();

		$this->db->select('ci_shops.shop_name, payment_pages.page_id, payment_pages.page_name');
		$this->db->from('payment_pages');
		$this->db->join('ci_shops', 'ci_shops.shop_id = payment_pages.shop_id ');
		if(!empty($shops)) : 
		$this->db->where_in('payment_pages.shop_id', $shops);
		else : 
		$this->db->where('payment_pages.shop_id', null);
		endif;
		$pages = $this->db->get();
		return $pages;
	}
	
	function get_shops_select($selected = '', $id = 'shop_id', $name= 'shop_name'){
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
	
	function save_page($page_details = array(), $page_id = null){
		if($page_id) : 
		$this->db->where('page_id', $page_id)->update('payment_pages', $page_details);
		else : 
		$this->db->insert('payment_pages', $page_details);
		endif;
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
	
	function get_page($page_id = null)
	{
		$page = $this->db->join('ci_shops', 'ci_shops.shop_id = payment_pages.shop_id ')
		->where('payment_pages.page_id', $page_id)
		->get('payment_pages');
		return $page->row();
	}
	function delete($page_id = null){
		$page = $this->db->where('page_id', $page_id)->get('payment_pages')->row();
		
		$this->db->where('page_id', $page_id)
		->delete('payment_pages');
		
		if(is_file(UPLOADSDIR.'payment_pages/'.$page->image)){
			unlink(UPLOADSDIR.'payment_pages/'.$page->image);
		}
	}
	function get_page_by_identifier($identifier = null){
		$page = $this->db->join('ci_shops', 'ci_shops.shop_id = payment_pages.shop_id ')
		->join('ci_businesses', 'ci_businesses.business_id = ci_shops.business ')
		->where('payment_pages.page_unique_id', $identifier)
		->get('payment_pages')
		->row();
		return $page;
	}
	function get_page_by_id($id = null){
		$page = $this->db->join('ci_shops', 'ci_shops.shop_id = payment_pages.shop_id ')
		->join('ci_businesses', 'ci_businesses.business_id = ci_shops.business ')
		->where('payment_pages.page_id', $id)
		->get('payment_pages')
		->row();
		return $page;
	}
	function payment_transactions($payment_details, $id = null){
		if($id === null) : 
			// insert into the table
			$this->db->insert('ci_payment_transactions', $payment_details);
			$id = $this->db->insert_id();
		else : 
			// update the table
			$this->db->where('transaction_id', $id)
			->update('ci_payment_transactions', $payment_details);
		endif; 
		return $id;
	}

	function allowed_toview($page_id = 0){
		$shops = $this->get_shops();

		$page = $this->db->select('shop_id')
					->from('payment_pages')
					->where('page_id', $page_id)
					->get()->row();
		if(in_array($page->shop_id,$shops)){
			return true;
		}
		else{
			return false;
		}
	}
	
	

}