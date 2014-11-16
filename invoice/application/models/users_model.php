<?php
 class Users_model extends CI_Model 
{
	function save_user($user_details){
		$this->db->insert('ci_users', $user_details);
		return $this->db->insert_id();
	}
	function selectuser($username, $password)
    {
		$this->db->select('*');
		$this->db->from('ci_users');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
        $query = $this->db->get();
        return $query;
    }
	function select_email($username)
	{
		$this->db->select('*');
		$this->db->from('ci_users');
		$this->db->where('username', $username);
		$user_data = $this->db->get();
		return $user_data;
	}
	function resetpassword($username = '', $password_details = array())
	{
		$this->db->where('username', $username);
		$this->db->update('ci_users', $password_details);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display users
|----------------------------------------------------------------------------------------------------------*/
	function get_users()
	{
		$business = get_business_config();
		$logged_user 	=	$this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('ci_users');
		$this->db->where ('user_id != ', $logged_user);
		$this->db->where ('created_by', $logged_user);
		$users = $this->db->get();
		return $users;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if username exists
|----------------------------------------------------------------------------------------------------------*/
	function username_exists($username = '')
	{
		$this->db->select('username');
		$this->db->where('username', $username);
		$this->db->from('ci_users');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		return true;
		else
		return false;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if email exists
|----------------------------------------------------------------------------------------------------------*/
	function email_exists($email = '', $userid = '')
	{
		$this->db->select('user_email');
		if($userid != '')
		{
		$this->db->where('user_id != ', $userid);
		}
		$this->db->where('user_email', $email);
		$this->db->from('ci_users');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		return true;
		else
		return false;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete user
|----------------------------------------------------------------------------------------------------------*/
	function delete_user($user_id = 0)
	{
		//delete user
		$this->db->where('user_id', $user_id);
		$this->db->delete('ci_users');
	}
	function get_user_business($username = ''){
		$user_details = $this->db->where('username', $username)->get('ci_users')->row();
		$user = $user_details->user_id;
		$level = $user_details->user_level;
		
		if($level == 1) : 
			$config = $this->db->where('user_id', $user)->get('ci_businesses')->row();
		else : 
			$shop = $this->db->where('manager', $user)->get('ci_shops')->row();
			if(empty($shop)) : 
				$userdata = $this->db->where('user_id', $user)->get('ci_users')->row();
				$business = $this->db->where('user_id', $userdata->created_by)->get('ci_businesses')->row();
				$config = $this->db->where('business_id', $business->business_id)->get('ci_businesses')->row();
			else : 
				$config = $this->db->where('business_id', $shop->business)->get('ci_businesses')->row();
			endif;
		endif;
		
		return $config;
	}
}
