<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {
	protected $title = 'Settings';
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('settings_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit system configurations
|----------------------------------------------------------------------------------------------------------*/
	public function index()
	{
		$data = array();
		if($this->input->post('updatesettingsbtn'))
		{
			$this->form_validation->set_rules('companyname', 'company name', 'trim|xss_clean');
			$this->form_validation->set_rules('companyaddress', 'company address', 'trim|xss_clean');
			$this->form_validation->set_rules('companyfax', 'company fax', 'trim|xss_clean');
			$this->form_validation->set_rules('companyemail', 'company email', 'trim|valid_email|xss_clean');
			$this->form_validation->set_rules('companyphone', 'company phone', 'trim|xss_clean');
			$this->form_validation->set_rules('companywebsite', 'company website', 'trim|xss_clean');
			$this->form_validation->set_rules('currency', 'currency symbol', 'trim|xss_clean');
			if($this->form_validation->run()) 
			{
				$admin = $this->session->userdata('user_id');
				$setting_id = $this->input->post('business_id');
				$business_details = array(
						'business_name' => $this->input->post('companyname'),
						'user_id' 		=> $admin,
						'address' 		=> $this->input->post('companyaddress'),
						'fax' 			=> $this->input->post('companyfax'),
						'email' 		=> $this->input->post('companyemail'),
						'phone' 		=> $this->input->post('companyphone'),
						'currency' 		=> $this->input->post('currency'),
						'website' 		=> $this->input->post('companywebsite'),
				);
				
				$this->settings_model->savesettings($business_details, $setting_id);
				$this->session->set_flashdata('success', 'The settings have been saved successfully !!');
				redirect('settings');
			}
		}
		if($this->input->post('updatelogobtn'))
		{
			if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) $_POST['logo'] = 'uploadfile'; 
			$this->form_validation->set_rules('logo', 'logo', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()) 
			{
				$setting_id = $this->input->post('business_id');
				$ff = $_FILES['logo'];		
				$extension= strtolower(end(explode(".",$ff['name'])));
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
				if(!isset($data['logoerror'])){
				$fname= time();
				 $name_ext = end(explode(".", basename($ff['name'])));
				 $name = str_replace('.'.$name_ext,'',basename($ff['name']));		  
				 $uploadfile = UPLOADSDIR.$fname.'.'.$name_ext;
				 if (move_uploaded_file($ff['tmp_name'], $uploadfile)) 
				 {
				 	$logo_details = array('logo'=> $fname.'.'.$name_ext);
					$this->settings_model->savesettings($logo_details, $setting_id);
					$this->session->set_flashdata('logosuccess', 'The logo has been uploaded successfully !!');
					redirect('settings');
				 }
				 }
			}
		}
		$data['title'] 			= $this->title;
		$data['settings']		= $this->settings_model->get_business_settings();
		$data['pagecontent'] 	= 'settings/sitesettings';
		$this->load->view('common/holder', $data);
	}

}