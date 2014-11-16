<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_page extends CI_Controller {
	protected $title = 'Payment Page';
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('payment_page_model');
		$this->load->model('shop_model');
	}
	public function index(){
		$data['pages'] 			= $this->payment_page_model->get_pages();
		$data['title'] 			= $this->title;
		$data['pagecontent'] 	= 'payment_page/pages';
		$this->load->view('common/holder', $data);
	}
	public function new_page()
	{
		$data = array();
		if($this->input->post('createpagebtn'))
		{
			$this->form_validation->set_rules('shop_id', 'shop', 'trim|required|xss_clean');
			$this->form_validation->set_rules('page_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('page_description', 'description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('goods_name', 'goods name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('sum', 'sum', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('recurrent', 'recurrent', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
				$ff = $_FILES['image'];
				$extension = strtolower(end(explode(".",$ff['name'])));
				$ext = array('jpg', 'jpeg', 'png', 'gif');
				$maxSize = 10097152;
				if(!in_array($extension,$ext))
				{
					$data['imageerror'] = 'File not valid';
				}
				else if($ff['size']>$maxSize)
				{
					$data['imageerror'] ='File maximum size exceeded';
				}
			}
			if($this->form_validation->run() && !isset($data['imageerror']))
			{
				
				$fname= time();
				$name_ext = end(explode(".", basename($ff['name'])));
				$name = str_replace('.'.$name_ext,'',basename($ff['name']));
				$uploadfile = UPLOADSDIR.'payment_pages/'.$fname.'.'.$name_ext;
				if (move_uploaded_file($ff['tmp_name'], $uploadfile))
				{
					$image_name 	= $fname.'.'.$name_ext;
				}
				else { $image_name 	= ''; }
				
				$change_sum = ( $this->input->post('change_sum') ) ?  $this->input->post('change_sum') : 0 ;
				$page_details = array(
						'shop_id'			=> $this->input->post('shop_id'),
						'page_name'			=> $this->input->post('page_name'),
						'description'		=> $this->input->post('page_description'),
						'goods_name'		=> $this->input->post('goods_name'),
						'sum'				=> $this->input->post('sum'),
						//'recurrent'			=> $this->input->post('recurrent'),
						'image'			  	=> $image_name,
						'user_change_sum'	=> $change_sum,
						'page_unique_id' 	=> md5(uniqid(rand(), true))
				);
				$this->payment_page_model->save_page($page_details);
				$this->session->set_flashdata('success', 'payment page has been created successfully !!');		
				redirect('payment_page');
			}
		}
		$data['title'] 	= $this->title;
		$data['shops'] = $this->payment_page_model->get_shops_select();
		$data['pagecontent'] 	= 'payment_page/new_page';
		$this->load->view('common/holder', $data);
	}
	public function edit($page_id = null){
		$data = array();
		if(!$this->payment_page_model->allowed_toview($page_id)){
			redirect('payment_page');
		}
		if($this->input->post('createpagebtn'))
		{
			$page_id = $this->input->post('page_id');
			$this->form_validation->set_rules('page_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('page_description', 'description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('goods_name', 'goods name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('sum', 'sum', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('recurrent', 'recurrent', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
				$ff = $_FILES['image'];
				$extension = strtolower(end(explode(".",$ff['name'])));
				$ext = array('jpg', 'jpeg', 'png', 'gif');
				$maxSize = 10097152;
				if(!in_array($extension,$ext))
				{
					$data['imageerror'] = 'File not valid';
				}
				else if($ff['size']>$maxSize)
				{
					$data['imageerror'] ='File maximum size exceeded';
				}
			}
			if($this->form_validation->run() && !isset($data['imageerror']))
			{
				$change_sum = $this->input->post('change_sum');
				$change_sum = ( $change_sum == 1 ) ?  $this->input->post('change_sum') : '0' ;
				
				$page_details = array(
						'page_name'			=> $this->input->post('page_name'),
						'description'		=> $this->input->post('page_description'),
						'goods_name'		=> $this->input->post('goods_name'),
						'sum'				=> $this->input->post('sum'),
						//'recurrent'			=> $this->input->post('recurrent'),
						'user_change_sum'	=> $change_sum,
				);

				if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
				$fname= time();
				$name_ext = end(explode(".", basename($ff['name'])));
				$name = str_replace('.'.$name_ext,'',basename($ff['name']));
				$uploadfile = UPLOADSDIR.'payment_pages/'.$fname.'.'.$name_ext;
				if (move_uploaded_file($ff['tmp_name'], $uploadfile))
				{
					$page = $this->common_model->select_record('payment_pages', 'page_id', $page_id);
					$image_name 	= $fname.'.'.$name_ext;
					$page_details['image'] = $image_name;
					if(is_file(UPLOADSDIR.'payment_pages/'.$page->image)){
						unlink(UPLOADSDIR.'payment_pages/'.$page->image);
					}
				}
				}
				$this->payment_page_model->save_page($page_details, $page_id);
				$this->session->set_flashdata('success', 'payment page has been saved successfully !!');
				redirect('payment_page');
			}
		}
		$data['title'] 			= $this->title;
		$data['page'] 			= $this->payment_page_model->get_page($page_id);
		$data['pagecontent'] 	= 'payment_page/edit_page';
		$this->load->view('common/holder', $data);
	}
	
	public function delete($page_id = null){
		//$this->payment_page_model->delete($page_id);
		//$this->session->set_flashdata('success', 'Page has been deleted successfully !!');
		//redirect('payment_page');
	}
}