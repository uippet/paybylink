<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apifrm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}

	public function index($apikey = ''){
		$data['api']	= $this->api_model->apifrm($apikey);
		$this->load->view('api/apifrm', $data);
	}

}