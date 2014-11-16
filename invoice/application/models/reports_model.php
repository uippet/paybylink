<?php
 class Reports_model extends CI_Model 
{
	function payments_summary($shop = 'all', $from_date = '', $to_date = '')
	{
		$business = get_business_config();
		$business_id = (!empty($business)) ? $business->business_id : null ;
		
		$this->db->select('*');
		$this->db->from('ci_payments');
		$this->db->join('ci_invoices', 'ci_invoices.invoice_id = ci_payments.invoice_id');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->join('ci_shops', 'ci_shops.shop_id = ci_invoices.shop_id');
		if($shop != 'all')
		{
			$this->db->where('ci_invoices.shop_id', $shop);
		}
		if($from_date != '' && $to_date != '')
		{
		$this->db->where('payment_date >=', date('Y-m-d', strtotime($from_date)));
		$this->db->where('payment_date <=', date('Y-m-d', strtotime($to_date)));
		}
		
		$this->db->where('ci_shops.business', $business_id);
		$this->db->order_by('ci_payments.payment_date', 'desc');
		$payment_results = $this->db->get();
		return $payment_results;
	}
	function payment_history($shop = 'all', $from_date = '', $to_date = '')
	{
		$business = get_business_config();
		$business_id = (!empty($business)) ? $business->business_id : null ;
		$shops = $this->get_business_shops($business_id);

		$this->db->select('*');
		$this->db->from('ci_payment_transactions');
		$this->db->order_by('ci_payment_transactions.paymentDatetime', 'desc');
		if($from_date != '' && $to_date != '')
		{
			$this->db->where('paymentDatetime >=', date('Y-m-d', strtotime($from_date)));
			$this->db->where('paymentDatetime <=', date('Y-m-d', strtotime($to_date)));
		}
		$this->db->where_in('shopid', $shops);
		$payment_results = $this->db->get();
		return $payment_results;
	}
	function client_statement($client_id = 0)
	{
		$statement = array();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('client_id', $client_id);
		$this->db->order_by('ci_invoices.invoice_id', 'ASC');
		$invoices = $this->db->get();
		$counter = 0;
		foreach($invoices->result_array() as $count=>$invoice)
		{
			$this->db->select('*');
			$this->db->from('ci_payments');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$this->db->order_by('ci_payments.payment_date', 'ASC');
			$payments = $this->db->get();
			$status = ($payments->num_rows() > 0 && $invoice['invoice_status'] !='PAID') ? 'PARTIALLY PAID' : $invoice['invoice_status'];
			
			$this->db->select('*');
			$this->db->from('ci_invoice_items');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$items = $this->db->get();
			$invoice_total = 0;
			foreach($items->result_array() as $item_count=>$item)
			{
				$invoice_total += ($item['item_quantity'] * $item['item_price'])-$item['item_discount'];
			}
			$statement[$counter]['activity']	=	'Invoice Generated (#'.$invoice['invoice_number'].' - '.$status.')';
			$statement[$counter]['amount']		=	$invoice_total-$invoice['invoice_discount'];
			$statement[$counter]['transaction_type'] = 'invoice';
			
			$counter++;
			
			foreach($payments->result_array() as $payments_count=>$payment)
			{
			$statement[$counter]['date']		=	$payment['payment_date'];
			$statement[$counter]['activity']	=	'Payment Received ';
			$statement[$counter]['amount']		=	$payment['payment_amount'];
			$statement[$counter]['transaction_type'] = 'payment';
			$counter++;
			}
		}
		return $statement;
	}
	function client_stats($client_id = 0){
		$stats = array();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('client_id', $client_id);
		$this->db->order_by('ci_invoices.invoice_id', 'DESC');
		$invoices = $this->db->get();
		$counter = 0;
		$total_invoiced = 0; 
		$total_received = 0; 
		foreach($invoices->result_array() as $count=>$invoice)
		{		
			//get invoices totals
			$this->db->select('*');
			$this->db->from('ci_invoice_items');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$items = $this->db->get();
			$invoice_total = 0;
			foreach($items->result_array() as $item_count=>$item)
			{
				$invoice_total += ($item['item_quantity'] * $item['item_price']) - $item['item_discount'];
			}
			
			//get payments totals
			$this->db->select('*');
			$this->db->from('ci_payments');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$this->db->order_by('ci_payments.payment_date', 'DESC');
			$payments = $this->db->get();
			foreach($payments->result_array() as $payments_count=>$payment)
			{
				$total_received += $payment['payment_amount'];
			}
			
		$total_invoiced += $invoice_total - $invoice['invoice_discount'];
		}
		$stats['total_invoiced']		=	$total_invoiced;
		$stats['total_received']		=	$total_received;
		return $stats;
	}
	function invoices_report($client_id = 0)
	{
		$invoices_report = array();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('ci_invoices.user_id', $this->session->userdata('user_id'));
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		if($client_id != 0)
		{	
			$this->db->where('ci_invoices.client_id', $client_id);
		}
		$this->db->order_by('ci_invoices.invoice_id', 'DESC');
		$invoices = $this->db->get();
		$counter = 0;
		foreach($invoices->result_array() as $count=>$invoice)
		{
			$this->db->select('*');
			$this->db->from('ci_payments');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$this->db->order_by('ci_payments.payment_date', 'DESC');
			$payments = $this->db->get();
			$status = ($payments->num_rows() > 0 && $invoice['invoice_status'] !='PAID') ? 'PARTIALLY PAID' : $invoice['invoice_status'];
			
			$this->db->select('*');
			$this->db->from('ci_invoice_items');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$items = $this->db->get();
			$invoice_total = 0;
			$items_total_discount = 0;
			
			foreach($items->result_array() as $item_count=>$item)
			{
				$items_total = ($item['item_quantity'] * $item['item_price']);
				$items_total_discount += $item['item_discount'];
				$invoice_total+= $items_total;
			}
			$invoices_report[$counter]['invoice_number']	=	$invoice['invoice_number'];
			$invoices_report[$counter]['invoice_client']	=	$invoice['client_name'];
			$invoices_report[$counter]['invoice_amount']	=	$invoice_total-$invoice['invoice_discount']-$items_total_discount;
			$invoices_report[$counter]['invoice_status'] 	= 	$status;
			$invoices_report[$counter]['invoice_id'] 		= 	$invoice['invoice_id'];

			$counter++;
		}
		return $invoices_report;
	}
	
	function get_business_shops($id = 'all'){
		$business = get_business_config();
		$business_id = (!empty($business)) ? $business->business_id : null ;
	
		$this->db->select('payment_shop_id');
		$this->db->where('business', $business_id);
		if($id !=  'all' ) : 
			$this->db->where('shop_id', $id);
		endif;
		$query = $this->db->get('ci_shops');
		
		$shops = array();
		foreach ($query->result_array() as $shop) : 
			array_push($shops, $shop['payment_shop_id']);
		endforeach;
	
		return $shops;
	}
}
