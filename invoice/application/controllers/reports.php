<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	protected $title 		= 'Reports';
	protected $activemenu 	= 'reports';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('reports_model');
		$this->load->model('clients_model');
		$this->load->model('shop_model');
	}
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['pagecontent'] 	= 'reports/reports';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display payment summary
|----------------------------------------------------------------------------------------------------------*/	
	function payment_summary()
	{
		$data 		= array();
		$shop 	= $this->input->post('shop');
		$from_date 	= $this->input->post('from_date');
		$to_date 	= $this->input->post('to_date');
		
		$selected = ($shop != '') ? $shop : 0;
		$data['shops'] 	= $this->shop_model->get_business_shops($selected);
		$data['payments']	= $this->reports_model->payments_summary($shop, $from_date, $to_date);
		$payments_results 	= $this->load->view('reports/payments_summary', $data, true);
		echo $payments_results;
	}
	
/*---------------------------------------------------------------------------------------------------------
 | Function to display payment history
|----------------------------------------------------------------------------------------------------------*/
	function payment_history()
	{
		$data 		= array();
		$from_date 	= $this->input->post('from_date');
		$to_date 	= $this->input->post('to_date');
		
		$data['payments']	= $this->reports_model->payment_history($from_date, $to_date);
		$payments_results 	= $this->load->view('reports/payments_history', $data, true);
		echo $payments_results;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display client statement
|----------------------------------------------------------------------------------------------------------*/	
	function client_statement()
	{
		$data = array();
		$selected = ($this->input->post('client_id')) ? $this->input->post('client_id') : 0;
		if($this->input->post('client_id'))
		{
		$data['statement_details'] 	= $this->reports_model->client_statement($this->input->post('client_id'));
		$data['stats'] 				= $this->reports_model->client_stats($this->input->post('client_id'));
		}
		$data['clients'] 	= $this->clients_model->get_business_clients('ci_clients', 'client_id', 'client_name', $selected);
		$client_statement 	= $this->load->view('reports/client_statement', $data, true);
		echo $client_statement;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display invoices report
|----------------------------------------------------------------------------------------------------------*/	
	function invoices_report()
	{
		$data = array();
		$selected = ($this->input->post('client_id')) ? $this->input->post('client_id') : 0;
		$data['invoices_report'] 	= $this->reports_model->invoices_report($this->input->post('client_id'));
		$data['clients'] 	= $this->clients_model->get_business_clients('ci_clients', 'client_id', 'client_name', $selected);
		$invoices_report 	= $this->load->view('reports/invoices_report', $data, true);
		echo $invoices_report;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display clients contact list
|----------------------------------------------------------------------------------------------------------*/	
	function clients_contact_list()
	{
		$data = array();
		$data['clients'] 			= $this->clients_model->get_clients();
		$clients_contact_list 		= $this->load->view('reports/clients_contact_list', $data, true);
		echo $clients_contact_list;
	}
}