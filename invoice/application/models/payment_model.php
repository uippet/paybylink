<?php
 class Payment_model extends CI_Model 
{
	function yandex_pay($payment_details = array()){
		$this->db->insert('ci_payments', $payment_details);
		$payment_id = $this->db->insert_id();
		return $payment_id;
	}
	
	function update_payment($payment_id = 0, $update_details = array()){
		$this->db->where('payment_id', $payment_id)
		->update('ci_payments', $update_details);
	}
	
	function get_payment($payment_id = 0){
		$payment = $this->db->where('payment_id', $payment_id)->get('ci_payments')->row();
		return $payment;
	}
	function update_transaction($payment_id = 0, $update_details = array()){
		$this->db->where('transaction_id', $payment_id)
		->update('ci_payment_transactions', $update_details);
	}

}