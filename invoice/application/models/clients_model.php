<?php
 class Clients_model extends CI_Model 
{
	
/*---------------------------------------------------------------------------------------------------------
| Function to check if email exists
|----------------------------------------------------------------------------------------------------------*/
	function email_exists($email = '', $client_id = '')
	{
		$this->db->select('client_email');
		if($client_id != '')
		{
		$this->db->where('client_id != ', $client_id);
		}
		$this->db->where('client_email', $email);
		$this->db->from('ci_clients');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		return true;
		else
		return false;
	}
	function delete_client($client_id = 0)
	{
		//delete invoices
		$this->db->select('invoice_id');
		$this->db->where('client_id', $client_id);
		$invoices = $this->db->get('ci_invoices');
		foreach($invoices->result_array() as $count=>$invoice){
		//delete items
		$this->db->where('invoice_id', $invoice['invoice_id']);
		$this->db->delete('ci_invoice_items');
		//delete payments
		$this->db->where('invoice_id', $invoice['invoice_id']);
		$this->db->delete('ci_payments');
		}
		//delete invoices
		$this->db->where('client_id', $client_id);
		$this->db->delete('ci_invoices');
		//delete client
		$this->db->where('client_id', $client_id);
		$this->db->delete('ci_clients');
	}
	
	function get_clients(){
		$business = get_business_config();
		$business = (!empty($business)) ? $business->business_id : null ;
		$clients = $this->db->where('business', $business)->get('ci_clients');
		return $clients;
	}
	
	function get_business_clients($selected = '', $id = 'client_id', $name= 'client_name'){
		$business = get_business_config();
		$business_id = (!empty($business)) ? $business->business_id : null ;
	
		$query = $this->db->where('business', $business_id)->get('ci_clients');
		$select = '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
				$selected_option = ($selected==$row[$id]) ? ' selected="selected" ':' ';
				$select.='<option value="'.$row[$id].'" '. $selected_option.'>'.trim(strtoupper($row[$name])).'</option>';
			}
		}
		return $select;
	}
}
