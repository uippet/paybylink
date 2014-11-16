<?php
 class Invoice_model extends CI_Model 
{
	function get_invoices($status = 'all')
	{
		$shops = $this->get_business_shops();
		
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		
		if($status != 'all')
		{
		$this->db->where('ci_invoices.invoice_status', $status);
		}
		$invoices = $this->db->get()->result_array();
		$invoice_amount = 0;
		foreach($invoices as $invoice_count=>$invoice)
		{
			$invoice_totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			$invoices[$invoice_count]['invoice_amount'] = $invoice_totals['item_total'] + $invoice_totals['tax_total'] - $invoice['invoice_discount'];
			$invoices[$invoice_count]['total_paid'] = $this->get_invoice_paid_amount($invoice['invoice_id']);
		}
		return $invoices;
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
	function invoice_stats()
	{
		$shops = $this->get_business_shops();
		$stats = array();
		//Get all invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$stats['all_invoices'] = $this->db->count_all_results();
		//Get all Paid invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_status', 'paid');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$stats['paid_invoices'] = $this->db->count_all_results();
		//Get all unpaid invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_status', 'unpaid');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$stats['unpaid_invoices'] = $this->db->count_all_results();
		//Get all cancelled invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_status', 'cancelled');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$stats['cancelled_invoices'] = $this->db->count_all_results();
		return $stats;
	}
	function recent_invoices()
	{
		$shops = $this->get_business_shops();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		if(!empty($shops)) : 
		$this->db->where_in('shop_id', $shops);
		else :
		$this->db->where('shop_id', null);
		endif; 
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->limit(5);
		$this->db->order_by('ci_invoices.invoice_id', 'DESC');
		$invoices = $this->db->get()->result_array();
		foreach($invoices as $invoice_count=>$invoice)
		{
			$invoice_totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			$invoices[$invoice_count]['invoice_amount'] = $invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice['invoice_discount'];
			$invoices[$invoice_count]['total_paid'] = $this->get_invoice_paid_amount($invoice['invoice_id']);
		}
		return $invoices;
	}
	
	function overdue_invoices()
	{
		$shops = $this->get_business_shops();
		$today = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->where('ci_invoices.invoice_due_date < ', $today);
		$this->db->where('ci_invoices.invoice_status', 'unpaid');
		$this->db->order_by('ci_invoices.invoice_id', 'DESC');
		$invoices = $this->db->get()->result_array();
		foreach($invoices as $invoice_count=>$invoice)
		{
			$invoice_totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			$invoices[$invoice_count]['invoice_amount'] = $invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice['invoice_discount'];
			$invoices[$invoice_count]['total_paid'] = $this->get_invoice_paid_amount($invoice['invoice_id']);
		}
		return $invoices;
	}
	function get_invoice_details($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->where('ci_invoices.invoice_id', $invoice_id);
		return $this->db->get()->row();
	}
	function get_invoice_data($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->join('ci_shops', 'ci_shops.shop_id = ci_invoices.shop_id');
		$this->db->where('ci_invoices.invoice_id', $invoice_id);
		$invoice_details = $this->db->get()->row();
		
		$invoice_totals 	= $this->get_invoice_total_amount($invoice_id);
		$invoice_paid_amt 	= $this->get_invoice_paid_amount($invoice_id);
		
		$invoice_details->invoice_items = $this->get_invoice_items($invoice_id);
		
		$invoice_details->invoice_total_amount = $invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice_details->invoice_discount;
		$invoice_details->invoice_total_paid = $invoice_paid_amt;
		$invoice_details->invoice_balance = ($invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice_details->invoice_discount) - $invoice_paid_amt;
		return $invoice_details;
	}
	function get_invoice_items($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_invoice_items');
		$this->db->where('ci_invoice_items.invoice_id', $invoice_id);
		$items = $this->db->get()->result_array();
		foreach($items as $item_count=>$item)
		{
			$items[$item_count]['item_total'] = $item['item_price'] * $item['item_quantity'] - $item['item_discount'];
		}
		return $items;
	}
	function get_invoice_payments($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_payments');
		$this->db->where('ci_payments.payment_status', 'completed');
		$this->db->where('ci_payments.invoice_id', $invoice_id);
		$invoice_payments = $this->db->get();
		return $invoice_payments;
	}
	function delete_invoice($invoice_id = 0)
	{
		//delete items
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('ci_invoice_items');
		//delete payments
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('ci_payments');
		//delete invoices
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('ci_invoices');
	}
	function previewinvoice($invoice_id = 0)
	{
		$invoice_data = array();
		$this->db->select('*');
		$this->db->where('ci_invoices.invoice_id', $invoice_id);
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$invoice_data['invoice_details'] = $this->db->get()->row();
		//Get invoice items
		$this->db->select('*');
		$this->db->where('ci_invoice_items.invoice_id', $invoice_id);
		$this->db->from('ci_invoice_items');
		$invoice_data['invoice_items'] = $this->db->get()->result_array();

		$invoice_totals = $this->get_invoice_total_amount($invoice_id);
		$total_payments_received = $this->get_invoice_paid_amount($invoice_id);
		
		//get items discount totals
		$this->db->select_sum('item_discount');
		$this->db->where('invoice_id', $invoice_id);
		$items_discounts = $this->db->get('ci_invoice_items')->row();
		$items_discount_total = $items_discounts->item_discount;
		
		$invoice_data['invoice_totals'] = array('items_subtotal' => $invoice_totals['item_total'], 'items_taxes_total' => $invoice_totals['tax_total'], 'total_payments_received' => $total_payments_received, 'items_discount_total'=>$items_discount_total);
		
		//return details
		return $invoice_data;
	}
	function addpayment($invoice_id = 0, $payment_details = array())
	{
		$this->db->insert('ci_payments', $payment_details);
		$total_paid 	= $this->get_invoice_paid_amount($invoice_id);
		$invoice_total 	= $this->get_invoice_total_amount($invoice_id);
		if($total_paid >= $invoice_total['item_total']+$invoice_total['tax_total'])
		{
			$details = array('invoice_status'=>'PAID');
			$this->db->where('invoice_id', $invoice_id);
			$this->db->update('ci_invoices', $details);
		}
	}
	function get_invoice_paid_amount($invoice_id = 0)
	{
		$total_paid = 0;
		//get invoice paid amount
		$this->db->select('*');
		$this->db->from('ci_payments');
		$this->db->where('invoice_id', $invoice_id);
		$this->db->where('payment_status', 'completed');
		$invoice_payments = $this->db->get();
		$total_paid = 0;
		foreach($invoice_payments->result_array() as $payment_counter=>$payment)
		{
			$total_paid = $total_paid + $payment['payment_amount'];
		}
		return $total_paid;
	}
	function get_invoice_total_amount($invoice_id = 0)
	{
		$invoice_totals = array();
		$this->db->select('*');
		$this->db->from('ci_invoice_items');
		$this->db->where('invoice_id', $invoice_id);
		$invoice_items = $this->db->get();
		$item_total = 0;
		$tax_total = 0;
		$items_total_discount = 0;
		foreach($invoice_items->result_array() as $item_count=>$item)
		{
			$item_amount = ($item['item_quantity'] * $item['item_price']) - $item['item_discount'];
			$item_total = $item_total + $item_amount;
		}
		$invoice_totals['item_total'] = $item_total;
		$invoice_totals['tax_total']  = $tax_total;
		return $invoice_totals;
	}
	
	function invoice_shop_details($invoice_id = 0){
		$this->db->select('ci_invoices.shop_id, ci_shops.*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_id', $invoice_id);
		$this->db->join('ci_shops', 'ci_shops.shop_id = ci_invoices.shop_id', 'LEFT');
		$shop = $this->db->get()->row();
		return $shop;
	}
	
	function invoice_status($invoice_id = 0){
		$total_paid 	= $this->get_invoice_paid_amount($invoice_id);
		$invoice_total 	= $this->get_invoice_total_amount($invoice_id);
		if($total_paid >= $invoice_total['item_total'])
		{
			$details = array('invoice_status'=>'PAID');
			$this->db->where('invoice_id', $invoice_id);
			$this->db->update('ci_invoices', $details);
		}
	}

	function allowed_toview($invoice_id = 0){
		$shops = $this->get_business_shops();

		$business = $this->db->select('shop_id')
					->from('ci_invoices')
					->where('invoice_id', $invoice_id)
					->get()->row();
		if(in_array($business->shop_id,$shops)){
			return true;
		}
		else{
			return false;
		}
	}
}
 