<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	protected $title 		= 'Api';
	protected $activemenu 	= 'api';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('api_model');
		$this->load->model('shop_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display apis
|----------------------------------------------------------------------------------------------------------*/
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['apis']			= $this->api_model->get_apis();
		$data['pagecontent'] 	= 'api/apis';
		$this->load->view('common/holder', $data);
	}
	
	public function create(){
		$data = array();
		if($this->input->post('createapibtn'))
		{
			$this->form_validation->set_rules('shop', 'shop', 'trim|required|xss_clean');
			$this->form_validation->set_rules('api_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('where_used', 'where used', 'trim|required|xss_clean');
			$this->form_validation->set_rules('api_type', 'type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('recurrent', 'recurrent', 'trim|required|xss_clean');
			$this->form_validation->set_rules('api_key', 'api_key', 'trim|required|xss_clean');
			$this->form_validation->set_rules('recurrent_days', 'recurrent_days', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$api_details = array('shop_id'			=> $this->input->post('shop'),
						'api_name'		=> $this->input->post('api_name'),
						'where_used'	=> $this->input->post('where_used'),
						'api_type'		=> $this->input->post('api_type'),
						'recurrent'		=> $this->input->post('recurrent'),
						'recurrent_days'=> $this->input->post('recurrent_days'),
						'api_key'		=> $this->input->post('api_key'),
						'email'			=> $this->input->post('email_type'),
						'iframe'		=> $this->input->post('iframe_type'),
				);
				$this->api_model->save_api($api_details);
				$this->session->set_flashdata('success', 'API has been added successfully !!');
				redirect('api/create');
			}
		}
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['shops']			= $this->shop_model->get_business_shops();
		$data['pagecontent'] 	= 'api/create';
		$this->load->view('common/holder', $data);
	}
	
	public function edit($api_id = 0){
		$data = array();
		if($this->input->post('updateapibtn'))
		{
			$api_id = $this->input->post('api_id');
			$this->form_validation->set_rules('shop', 'shop', 'trim|required|xss_clean');
			$this->form_validation->set_rules('api_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('where_used', 'where used', 'trim|required|xss_clean');
			$this->form_validation->set_rules('api_type', 'type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('recurrent', 'recurrent', 'trim|required|xss_clean');
			$this->form_validation->set_rules('api_key', 'api_key', 'trim|required|xss_clean');
			$this->form_validation->set_rules('recurrent_days', 'recurrent_days', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$api_details = array('shop_id'			=> $this->input->post('shop'),
						'api_name'		=> $this->input->post('api_name'),
						'where_used'	=> $this->input->post('where_used'),
						'api_type'		=> $this->input->post('api_type'),
						'recurrent'		=> $this->input->post('recurrent'),
						'recurrent_days'=> $this->input->post('recurrent_days'),
						'api_key'		=> $this->input->post('api_key'),
						'email'			=> $this->input->post('email_type'),
						'iframe'		=> $this->input->post('iframe_type'),
				);
				$this->api_model->save_api($api_details, $api_id);
				$this->session->set_flashdata('success', 'API has been updated successfully !!');
				redirect('api');
			}
		}
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['api']			= $this->api_model->get_api($api_id);
		$data['shops']			= $this->shop_model->get_business_shops($data['api']->api_id);
		$data['pagecontent'] 	= 'api/edit';
		$this->load->view('common/holder', $data);
	}
	
	public function delete($api_id = 0){
		//$this->api_model->delete($api_id);
		//$this->session->set_flashdata('success', 'API has been deleted successfully !!');
		//redirect('api');
	}

}