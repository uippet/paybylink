<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_session_details() 
{
	$CI =& get_instance();
	$data = (object)$CI->session->all_userdata();
	return $data;
}
function is_logged_in()
{
	$CI =& get_instance();
	$is_logged_in = $CI->session->userdata('user_id');
	if(!isset($is_logged_in) || $is_logged_in != true)
	{
		redirect (base_url());   
	}       
}

// get total unpaid amount
function get_total_unpaid_amount(){
	$CI =& get_instance();
	$unpaid_amount = $CI->common_model->get_total_unpaid_amount();
	return $unpaid_amount;
}
// get total paid amount
function get_total_paid_amount(){
	$CI =& get_instance();
	$paid_amount = $CI->common_model->get_total_paid_amount();
	return $paid_amount;
}
// get total overdue amount
function get_total_overdue_amount(){
	$CI =& get_instance();
	$overdue_amount = $CI->common_model->get_total_overdue_amount();
	return $overdue_amount;
}

function get_business_config(){
	$CI =& get_instance();
	$config = $CI->common_model->get_business_config();
	return $config;
}

//selected country would be retrieved from a database or as post data
function  country_dropdown($name, $id, $class, $selected_country,$top_countries=array(), $all, $selection=NULL, $show_all=TRUE ){
	// You may want to pull this from an array within the helper
	$countries = config_item('country_list');

	$html = "<select name='{$name}' id='{$id}' class='{$class}'>";
	$selected = NULL;
	if(in_array($selection,$top_countries)){
		$top_selection = $selection;
		$all_selection = NULL;
	}else{
		$top_selection = NULL;
		$all_selection = $selection;
	}
	if(!empty($selected_country)&&$selected_country!='all'&&$selected_country!='select'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='{$selected_country}'{$selected}>{$countries[$selected_country]}</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}else if($selected_country=='all'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='all'>All</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}else if($selected_country=='select'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='select'>Select</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}
	if(!empty($all)&&$all=='all'&&$selected_country!='all'){
		$html .= "<option value='all'>All</option>";
		$selected = NULL;
	}
	if(!empty($all)&&$all=='select'&&$selected_country!='select'){
		$html .= "<option value='select'>Select</option>";
		$selected = NULL;
	}
	
	if(!empty($top_countries)){
		$html .= "<optgroup label='Top Countries'>";
		foreach($top_countries as $value){
			if(array_key_exists($value, $countries)){
				if($value === $top_selection){
					$selected = "SELECTED";
				}
			$html .= "<option value='{$value}'{$selected}>{$countries[$value]}</option>";
			$selected = NULL;
			}
		}
		$html .= "</optgroup>";
	}

	if($show_all){
		$html .= "<optgroup label='All Countries'>";
		foreach($countries as $key => $country){
			if($key === $all_selection){
				$selected = "SELECTED";
			}
			$html .= "<option value='{$key}'{$selected}>{$country}</option>";
			$selected = NULL;
		}
		$html .= "</optgroup>";
	}
	
	$html .= "</select>";
	return $html;
    }
function limit_text($string, $limit) 
{
if (strlen($string) >= $limit)
return substr($string, 0, $limit-1)." ..."; // This is a test...
else
return $string;
}
function get_tax_select($tax_id)
{
	$CI =& get_instance();
	$tax_rates = $CI->common_model->get_select_option('ci_tax_rates', 'tax_rate_id', 'tax_rate_name', $tax_id);
	return $tax_rates;
}

function array_multi_subsort($array, $subkey)
{
    $b = array(); $c = array();

    foreach ($array as $k => $v)
    {
        $b[$k] = strtolower($v[$subkey]);
    }

    asort($b);
    foreach ($b as $key => $val)
    {
        $c[] = $array[$key];
    }

    return $c;
}

//function to get the invoice shop details
function invoice_shop_details($invoice_id = 0){
	$CI =& get_instance();
	$shop = $CI->invoice_model->invoice_shop_details($invoice_id);
	return $shop;
}
 
