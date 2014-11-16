<?php
 class Settings_model extends CI_Model 
{
	function get_business_settings(){
		$admin = $this->session->userdata('user_id');
		$business = $this->db->where('user_id', $admin)->get('ci_businesses')->row();
		return $business;
	}
	function savesettings ($details, $business_id)
    {
    	if($business_id != '') :
	    	$this->db->where('business_id', $business_id)->update('ci_businesses', $details);
    	else :
    		$this->db->insert('ci_businesses', $details);
    	endif;
    }	
}
