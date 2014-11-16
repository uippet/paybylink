<?php
 class Products_model extends CI_Model 
{
	function get_product_selections($product_ids = array())
	{
		$this->db->select('*');
		$this->db->from('ci_products');
		$this->db->where_in('product_id', $product_ids);
		$products = $this->db->get();
		return $products;
	}
	function delete_product($product_id = 0)
	{
		//delete product
		$this->db->where('product_id', $product_id);
		$this->db->delete('ci_products');
	}
	function get_products(){
		$business = get_business_config();
		$business = (!empty($business)) ? $business->business_id : null ;
		$products = $this->db->where('business', $business)->get('ci_products');
		return $products;
	}
		
}
