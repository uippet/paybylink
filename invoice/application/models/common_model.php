<?php
 class Common_model extends CI_Model 
{
	function dbinsert ($tablename, $details)
    {
		if($this->db->insert ($tablename, $details))
		{
			return true;
		}
		else
		{
			return false;
		}
    }
    function register($user_details = array())
    {
    	$this->db->insert ('ci_users', $user_details);
    	$user_id = $this->db->insert_id();
    	$business = array('user_id' => $user_id);
    	$this->db->insert ('ci_businesses', $business);
    }
	
	function saverecord($tablename, $details)
	{
		$this->db->insert ($tablename, $details);
		return $this->db->insert_id();
	}
	function db_select ($tablename)
    {
    	$query = $this->db->query("SELECT * FROM $tablename"); 
    	return $query;
    }
	function update_records($table, $field, $fieldvalue, $data)
    {
         $this->db->where( $field, $fieldvalue);
         $this->db->update($table, $data);
        return TRUE;

    }
	function select_record($tablename, $idname, $idvalue)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($idname, $idvalue);
		$results = $this->db->get();
		return $results->row();
	}
	function deleterecord($tablename, $idname, $idvalue)
	{
		$this->db->where($idname, $idvalue);
		$this->db->delete($tablename);
	}
	function get_business_config(){
		$user = $this->session->userdata('user_id');
		$level = $this->session->userdata('level');
		
		if($level == 1) : 
			$config = $this->db->where('user_id', $user)->get('ci_businesses')->row();
		else : 
			$shop = $this->db->where('manager', $user)->get('ci_shops')->row();
			if(empty($shop)) : 
				$userdata = $this->db->where('user_id', $user)->get('ci_users')->row();
				$business = $this->db->where('user_id', $userdata->created_by)->get('ci_businesses')->row();
				$config = $this->db->where('business_id', $business->business_id)->get('ci_businesses')->row();
			else : 
				$config = $this->db->where('business_id', $shop->business)->get('ci_businesses')->row();
			endif;
		endif;
		
		return $config;
	}
	function get_select_option($table,$id,$name,$selected=0){
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
	function get_last_id($table_name = '', $field_name)
	{
		$this->db->select_max($field_name);
		$this->db->from($table_name);
		$results = $this->db->get()->row();
		if($results->$field_name == '')
		{
			$last_id = 0;
		}
		else
		{
			$last_id = $results->$field_name;
		}
		return $last_id;
	}

	function get_total_paid_amount()
	{
		$shops = $this->get_business_shops();
		$total_paid = 0;
		//get invoice paid amount
		$this->db->select_sum('payment_amount');
		$this->db->from('ci_invoices');
		$this->db->join('ci_payments', 'ci_payments.invoice_id = ci_invoices.invoice_id');
		if(!empty($shops)) : 
		$this->db->where_in('ci_invoices.shop_id', $shops);
		else :
		$this->db->where('ci_invoices.shop_id', null);
		endif; 
		$invoice_payments = $this->db->get();
		$total_paid = 0;
		foreach($invoice_payments->result_array() as $payment_counter=>$payment)
		{
			$total_paid = $total_paid + $payment['payment_amount'];
		}
		return $total_paid;
	}
	function get_total_unpaid_amount()
	{
		$shops = $this->get_business_shops();
		$this->db->select('*');
		$this->db->from('ci_invoice_items');
		$this->db->join('ci_invoices', 'ci_invoices.invoice_id = ci_invoice_items.invoice_id');
		
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		
		$invoice_amount = $this->db->get()->result_array();
		$total_amount = 0;
		foreach ($invoice_amount as $count=>$item)
		{
		 $item_total = $item['item_price'] * $item['item_quantity'] - $item['item_discount'];
		
		 $total_amount+=$item_total;
		}
		$this->db->select_sum('payment_amount');
		
		$this->db->join('ci_payments', 'ci_payments.invoice_id = ci_invoices.invoice_id');
		if(!empty($shops)) : 
		$this->db->where_in('ci_invoices.shop_id', $shops);
		else :
		$this->db->where('ci_invoices.shop_id', null);
		endif; 

		$payments = $this->db->get('ci_invoices')->row();
		$total_amount -= $payments->payment_amount;
		
		$this->db->select_sum('invoice_discount');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$discounts = $this->db->get('ci_invoices')->row();
		$total_amount -= $discounts->invoice_discount;
		
		return $total_amount;
	}
	function get_total_overdue_amount()
	{
		$shops = $this->get_business_shops();
		$today = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('ci_invoices');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$overdue_invoices = $this->db->get();
		$total_overdue = 0;
		if($overdue_invoices->num_rows() > 0)
		{
		foreach ($overdue_invoices->result_array() as $count=>$invoice)
		{
			$this->db->select('*');
			$this->db->from('ci_invoice_items');
			$this->db->where('ci_invoice_items.invoice_id', $invoice['invoice_id']);
			$invoice_items = $this->db->get();
			$items_totals = 0;
			if($invoice_items->num_rows() > 0)
			{
				foreach($invoice_items->result_array() as $items=>$item)
				{
					$item_total = $item['item_price'] * $item['item_quantity'] - $item['item_discount'];
					$items_totals+=$item_total;
				}
			}
			$total_overdue += $items_totals-$invoice['invoice_discount'];
		}
		}
		return $total_overdue;
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
		
}
