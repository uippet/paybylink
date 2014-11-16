<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pp extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('payment_page_model');
	}
	
	public function index($identifier = null){
		$data = array();
		$data['page'] = $this->payment_page_model->get_page_by_identifier($identifier);
		$this->load->view('pp/pay', $data);
	}
	public function payment_form($page_id = 0, $payment_method = '', $amount = 0){
		$data = array();
		$data['page'] 			= $this->payment_page_model->get_page_by_id($page_id);
		$data['payment_method'] = $payment_method;
		$data['payment_amount'] = $amount;
		$this->load->view('pp/payment_frm_modal', $data);
	}
	public function pay(){
		$payment_details = array(
				'name' 			=> $this->input->post('name'),
				'email' 		=> $this->input->post('email'),
				'phone' 		=> $this->input->post('phone'),
				'paymentDatetime' => date('Y/m/d'),
				'sum' 			=> $this->input->post('amount'),
				'payment_status'=> 'pending',
		);
		
		$payment_id = $this->payment_page_model->payment_transactions($payment_details);
		
		$this->load->library('yandex');
		$this->yandex->add_field('ShopID', $this->input->post('ShopID'));
		$this->yandex->add_field('scid', $this->input->post('scid'));
		$this->yandex->add_field('Sum',  $this->input->post('amount')); // sum
		$this->yandex->add_field('customerNumber',  $this->input->post('email'));
		$this->yandex->add_field('MyField',  $payment_id);
		$this->yandex->add_field('paymentType', $this->input->post('paymentType'));
		$this->yandex->add_field('orderNumber', $payment_id);
		$this->yandex->add_field('cps_email', $this->input->post('email'));		
		$this->yandex->add_field('p_type', 'payment_page');
		if($payment_id)
			$this->yandex->submit_yandex_post(); // submit the fields to yandex
	}
}