<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shops extends CI_Controller {

	protected $title 		= 'Shops';
	protected $activemenu 	= 'shops';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('shop_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to list Shops
|----------------------------------------------------------------------------------------------------------*/	
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['shops']			= $this->shop_model->get_shop();
		$data['pagecontent'] 	= 'shops/shops';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new Shop
|----------------------------------------------------------------------------------------------------------*/	
	function create()
	{
		$data = array();
		if($this->input->post('createshopbtn'))
		{
			$this->form_validation->set_rules('shop_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('scid', 'scid', 'trim|xss_clean');
			$this->form_validation->set_rules('shoppw', 'shop pw', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_phone', 'shop phone', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_email', 'shop email', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_address', 'shop address', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_description', 'shop description', 'trim|xss_clean');
			if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])){
				$ff = $_FILES['logo'];
				$extension = strtolower(end(explode(".",$ff['name'])));
				$ext = array('jpg', 'jpeg', 'png', 'gif');
				$maxSize = 10097152;
				if(!in_array($extension,$ext))
				{
					$data['logoerror'] = 'File not valid';
				}
				else if($ff['size']>$maxSize)
				{
					$data['logoerror'] ='File maximum size exceeded';
				}
			}
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run() && !isset($data['logoerror']))
			{
						$fname= time();
						$name_ext = end(explode(".", basename($ff['name'])));
						$name = str_replace('.'.$name_ext,'',basename($ff['name']));
						$uploadfile = UPLOADSDIR.$fname.'.'.$name_ext;
						if (move_uploaded_file($ff['tmp_name'], $uploadfile))
						{
							$logo_name 	= $fname.'.'.$name_ext;
						}
						else { $logo_name 	= ''; }
						
				$business = $this->common_model->select_record('ci_businesses', 'user_id', $this->session->userdata('user_id'));
				if(!empty($business)) :  
				
				$ymoney 		= ($this->input->post('ymoney')) ? : '0';
				$credit_card 	= ($this->input->post('credit_card')) ? : '0';
				$mobile_phone 	= ($this->input->post('mobile_phone')) ? : '0';
				$kiosks 		= ($this->input->post('kiosks')) ? : '0';
				$webmoney 		= ($this->input->post('webmoney')) ? : '0';
				
				
				$shop_details = array(
						'shop_name'			=> $this->input->post('shop_name'),
						'scid'				=> $this->input->post('scid'),
						'payment_shop_id'	=> $this->input->post('payment_shop_id'),
						'shoppw'			=> $this->input->post('shoppw'),
						'shop_phone'		=> $this->input->post('shop_phone'),
						'shop_email'		=> $this->input->post('shop_email'),
						'shop_address'		=> $this->input->post('shop_address'),
						'shop_description'	=> $this->input->post('shop_description'),
						'business'			=> $business->business_id,
						'shop_logo'			=> $logo_name,
						'ymoney'			=> $ymoney,
						'credit_card'		=> $credit_card,
						'mobile_phone'		=> $mobile_phone,
						'kiosks'			=> $kiosks,
						'webmoney'			=> $webmoney,
				);
				$this->common_model->dbinsert('ci_shops', $shop_details);
				$this->session->set_flashdata('success', 'Shop has been added successfully !!');
				redirect('shops/create');
				else:
				$this->session->set_flashdata('error', 'Please add you business details first under the \'settings->system config\' menu !!');
				redirect('shops/create');
				endif;
			}
		}
		$data['title'] 				= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['pagecontent'] 		= 'shops/create_shop';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit Shop
|----------------------------------------------------------------------------------------------------------*/	
	function edit($shop_id = 0)
	{
		$data = array();
		if(!$this->shop_model->allowed_toview($shop_id)){
			redirect('shops');
		}
		if($this->input->post('editshopbtn'))
		{
			$shop_id = $this->input->post('shop_id');
			$this->form_validation->set_rules('shop_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('scid', 'sc id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('shoppw', 'shop pw', 'trim|required|xss_clean');
			$this->form_validation->set_rules('shop_phone', 'shop phone', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_email', 'shop phone', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_address', 'shop address', 'trim|xss_clean');
			$this->form_validation->set_rules('shop_description', 'shop description', 'trim|xss_clean');
			if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])){
				$ff = $_FILES['logo'];
				$extension = strtolower(end(explode(".",$ff['name'])));
				$ext = array('jpg', 'jpeg', 'png', 'gif');
				$maxSize = 10097152;
				if(!in_array($extension,$ext))
				{
					$data['logoerror'] = 'File not valid';
				}
				else if($ff['size']>$maxSize)
				{
					$data['logoerror'] ='File maximum size exceeded';
				}
			}
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run() && !isset($data['logoerror']))
			{
				$ymoney 		= ($this->input->post('ymoney')) ? : '0';
				$credit_card 	= ($this->input->post('credit_card')) ? : '0';
				$mobile_phone 	= ($this->input->post('mobile_phone')) ? : '0';
				$kiosks 		= ($this->input->post('kiosks')) ? : '0';
				$webmoney 		= ($this->input->post('webmoney')) ? : '0';
				
				
				$shop_details = array('shop_name'		=> $this->input->post('shop_name'),
						'scid'				=> $this->input->post('scid'),
						'payment_shop_id'	=> $this->input->post('payment_shop_id'),
						'shoppw'			=> $this->input->post('shoppw'),
						'shop_phone'		=> $this->input->post('shop_phone'),
						'shop_email'		=> $this->input->post('shop_email'),
						'shop_address'		=> $this->input->post('shop_address'),
						'shop_description'	=> $this->input->post('shop_description'), 
						'ymoney'			=> $ymoney,
						'credit_card'		=> $credit_card,
						'mobile_phone'		=> $mobile_phone,
						'kiosks'			=> $kiosks,
						'webmoney'			=> $webmoney,
				);
				
				$fname= time();
				$name_ext = end(explode(".", basename($ff['name'])));
				$name = str_replace('.'.$name_ext,'',basename($ff['name']));
				$uploadfile = UPLOADSDIR.$fname.'.'.$name_ext;
				if (move_uploaded_file($ff['tmp_name'], $uploadfile))
				{
					$shop = $this->common_model->select_record('ci_shops', 'shop_id', $shop_id);
					$logo_name 	= $fname.'.'.$name_ext;
					$shop_details['shop_logo'] = $logo_name;
					if(is_file(UPLOADSDIR.$shop->shop_logo)){
						unlink(UPLOADSDIR.$shop->shop_logo);
					}
				}
				
				
				$this->common_model->update_records('ci_shops', 'shop_id', $shop_id, $shop_details);
				$this->session->set_flashdata('success', 'Shop has been updated successfully !!');
				redirect('shops/edit/'.$shop_id);
			}
		}
		$data['title'] 				= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['shop']				= $this->common_model->select_record('ci_shops', 'shop_id', $shop_id);
		$data['pagecontent'] 		= 'shops/edit_shop';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete Shop
|----------------------------------------------------------------------------------------------------------*/
	public function delete($shop_id = 0)
	{
		//$this->common_model->deleterecord('ci_shops', 'shop_id', $shop_id);
		//$this->session->set_flashdata('success', 'Shop has been deleted successfully !!');
		//redirect('shops');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */