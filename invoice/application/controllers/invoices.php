<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends CI_Controller {

	protected $title 		= 'Invoices';
	protected $activemenu 	= 'invoices';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('invoice_model');
		$this->load->model('shop_model');
		$this->load->model('clients_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to list invoices
|----------------------------------------------------------------------------------------------------------*/
	public function index($status = 'all')
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['invoices']		= $this->invoice_model->get_invoices($status);
		$data['status']			= $status;
		$data['pagecontent'] 	= 'invoices/invoices';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new invoice
|----------------------------------------------------------------------------------------------------------*/
	public function newinvoice()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['clients'] 		= $this->clients_model->get_business_clients('ci_clients', 'client_id', 'client_name');
		$data['shops'] 			= $this->shop_model->get_business_shops('ci_shops', 'shop_id', 'shop_name');
		$data['pagecontent'] 	= 'invoices/newinvoice';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display overdue invoices
|----------------------------------------------------------------------------------------------------------*/
	public function overdue()
	{
		$data = array();
		$this->activemenu 			= 'overdue';
		$data['title'] 				= $this->title;
		$data['activemenu'] 		= $this->activemenu;
		$data['overdue_invoices']	= $this->invoice_model->overdue_invoices();
		$data['pagecontent'] 		= 'invoices/overdue_invoices';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to calculate invoice totals
|----------------------------------------------------------------------------------------------------------*/
	function ajax_calculate_totals()
	{
		$items = json_decode($this->input->post('items'));
		$items_total_cost = 0;
		$invoice_total_tax = 0;
		$items_total_discount = 0;
		$invoice_discount_amount = $this->input->post('invoice_discount_amount');
		$invoice_id = $this->input->post('invoice_id');
		foreach ($items as $item) 
		{
			if($item->item_quantity != '' && $item->item_price != '')
			{
				$item_total 	=	$item->item_quantity * $item->item_price - $item->item_discount;
				$items_total_cost = $items_total_cost + $item_total;
				$items_total_discount += $item->item_discount;  
			}
		}
		$invoice_amount_paid = $this->invoice_model->get_invoice_paid_amount($invoice_id);
		$amount_due = $items_total_cost - $invoice_discount_amount - $invoice_amount_paid;
		$response = array(
                'success'           => 1,
                'items_total_cost'  => number_format($items_total_cost, 2),
				'items_sub_total1'  => number_format($items_total_cost - $invoice_discount_amount , 2),
				'invoice_discount_amount' => number_format($invoice_discount_amount, 2),
				'invoice_amount_due' => number_format($amount_due, 2)
				
            );
		echo json_encode($response);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to save new invoice
|----------------------------------------------------------------------------------------------------------*/
	function ajax_save_invoice()
	{
		$items = json_decode($this->input->post('items'));
		$invoice_number = $this->input->post('invoice_number');
		$invoice_items = 0;
		foreach ($items as $item) 
		{
			if($item->item_quantity != '' && $item->item_price != '')
			{
				$invoice_items++;
			}
		}
		if($invoice_items > 0)
		{
			if($invoice_number == ''){
			$invoice_details = array('user_id' 				=> $this->session->userdata('user_id'),
									 'client_id' 			=> $this->input->post('invoice_client'),
									 'shop_id' 				=> $this->input->post('invoice_shop'),
									 'invoice_number' 		=> $this->generate_invoice_number(),
									 'invoice_terms' 		=> $this->input->post('invoice_terms'),
									 'invoice_discount'		=> $this->input->post('invoice_discount_amount'),
									);
			$invoice_id = $this->common_model->saverecord('ci_invoices', $invoice_details);
			$send_email = true;
			}
			else
			{
				$invoice_details = array('client_id' 			=> $this->input->post('invoice_client'),
										 'invoice_terms' 		=> $this->input->post('invoice_terms'),
										 'invoice_status' 		=> $this->input->post('invoice_status'),
										 'invoice_discount'		=> $this->input->post('invoice_discount_amount'),
									);
				$invoice_id = $this->input->post('invoice_number');
				$this->common_model->update_records('ci_invoices', 'invoice_id', $invoice_id, $invoice_details);
				$send_email = false;
			}

			foreach ($items as $item) 
			{
				if($item->item_quantity != '' && $item->item_price != '')
				{
					$item_id = $item->item_id;
					$item_details = array ('invoice_id'			=> $invoice_id,
										   'item_name'			=> $item->item_name,
										   'item_quantity'		=> $item->item_quantity,
										   'item_description'	=> $item->item_description,
										   'item_order'			=> $item->item_order,
										   'item_price'			=> $item->item_price,
										   'item_discount'		=> $item->item_discount,
										  );
					if($item_id != '')
					{
						$this->common_model->update_records('ci_invoice_items', 'item_id', $item_id, $item_details);
						$this->session->set_flashdata('success', 'The invoice has been edited successfully !!');
					}
					else
					{
						$this->common_model->saverecord ('ci_invoice_items', $item_details);
						$this->session->set_flashdata('success', 'The invoice has been created successfully !!');
					}
				}
			}
			
			if($send_email)
			{
				$email_subject 	= 'Вам выставлен счет';
				$email_sent = $this->send_invoice($invoice_id, $email_subject);
				$success_message = 'Invoice has been sent!';
			}
			else {
				$success_message = 'Invoice has been saved!';
			}
			
			$response = array(
                'success'           => 1,
				'message'			=> $success_message,
            );
		}
		else
		{
			$response = array(
                'success'           => 0,
                'error'  			=> 'Please enter atleast one item',
            );
		}
		echo json_encode($response);	
	}
/*---------------------------------------------------------------------------------------------------------
| Function to generate invoice numbers
|----------------------------------------------------------------------------------------------------------*/
	function generate_invoice_number()
	{
		$last_invoice_id = $this->common_model->get_last_id('ci_invoices', 'invoice_id') + 1;
		return $last_invoice_id;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to filter invoices
|----------------------------------------------------------------------------------------------------------*/
	function ajax_filter_invoices()
	{
		$data = array();
		$invoice_status 	= $this->input->post('status');
		$data['invoices']	= $this->invoice_model->get_invoices($invoice_status);
		$data['status']		= ($invoice_status != 'all' ) ? $invoice_status : '';	
		$invoice_results 	= $this->load->view('invoices/filtered_invoices', $data, true);
		echo $invoice_results;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit invoice
|----------------------------------------------------------------------------------------------------------*/
	function edit($invoice_id = 0)
	{
		if(!$this->invoice_model->allowed_toview($invoice_id)){
			redirect('invoices');
		}
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['invoice_details']= $this->invoice_model->get_invoice_details($invoice_id);
		$data['invoice_items']	= $this->invoice_model->get_invoice_items($invoice_id);
		$data['invoice_payments']= $this->invoice_model->get_invoice_payments($invoice_id);
		$data['clients'] 		= $this->common_model->get_select_option('ci_clients', 'client_id', 'client_name', $data['invoice_details']->client_id);
		$data['shops'] 			= $this->common_model->get_select_option('ci_shops', 'shop_id', 'shop_name', $data['invoice_details']->shop_id);
		$data['pagecontent'] 	= 'invoices/editinvoice';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit invoice
|----------------------------------------------------------------------------------------------------------*/
	function delete_item($invoice_id=0, $item_id=0)
	{
		//$this->common_model->deleterecord('ci_invoice_items', 'item_id', $item_id);
		//$this->session->set_flashdata('success', 'The item has been deleted successfully !!');
		//redirect('invoices/edit/'.$invoice_id);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display products to be added in invoice 
|----------------------------------------------------------------------------------------------------------*/	
	function items_from_products()
	{
		$data = array();
		$this->load->model('products_model');
		$data['products'] = $this->products_model->get_products();
		$this->load->view('invoices/products_modal', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete an invoice 
|----------------------------------------------------------------------------------------------------------*/	
	function delete_invoice($invoice_id = 0)
	{
		//$this->invoice_model->delete_invoice($invoice_id);
		//$this->session->set_flashdata('success', 'The invoice has been deleted successfully !!');
		//redirect('invoices');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to enter payment for an invoice 
|----------------------------------------------------------------------------------------------------------*/	
	function enter_payment($invoice_id = 0)
	{
		$data = array();
		$data['invoice'] 			= $this->invoice_model->get_invoice_details($invoice_id);
		$this->load->view('invoices/enter_payment_modal', $data);
	}
	function addpayment()
	{
		$this->form_validation->set_rules('payment_amount', 'amount', 'trim|required|numeric|callback_amount_check|xss_clean');
		$this->form_validation->set_rules('payment_date', 'payment date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_note', 'payment note', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run())
		{
			if($this->input->post('payment_amount') <= 0){
			$this->form_validation->set_message('required', 'amount');
			}
			else{
			$invoice_id = $this->input->post('invoice_id');
			$payment_details = array('invoice_id'		=> $this->input->post('invoice_id'),
								  'payment_amount'		=> $this->input->post('payment_amount'),
								  'payment_date'		=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
								  'payment_note'		=> $this->input->post('payment_note'),
								 );
			$this->invoice_model->addpayment($invoice_id, $payment_details);
			$this->session->set_flashdata('success', 'Payment has been added successfully !!');
			$response = array(
					'success'           => 1
				);
				}
		}
		else
		{
		$this->load->helper('json_error');
				$response = array(
					'success'           => 0,
					'validation_errors' => json_errors()
				);
			
		}
		echo json_encode($response);	
	}
	function amount_check($str)
	{
		if ($str <= 0)
		{
			$this->form_validation->set_message('amount_check', 'The %s field can not be 0');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
/*---------------------------------------------------------------------------------------------------------
| Function to preview an invoice
|----------------------------------------------------------------------------------------------------------*/	
	function previewinvoice($invoice_id = 0)
	{
		$data 						= array();
		$data['title'] 				= $this->title;
		$data['invoice_details']	= $this->invoice_model->previewinvoice($invoice_id);
		$this->load->view('invoices/previewinvoice', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to send invoice to client
|----------------------------------------------------------------------------------------------------------*/	
	function emailclient($invoice_id = 0)
	{
		$data 						= array();
		$data['title'] 				= $this->title;
		$data['invoice_details']	= $this->invoice_model->get_invoice_details($invoice_id);
		$this->load->view('invoices/emailclient', $data);
	}

	function ajax_send_email()
	{
		$this->form_validation->set_rules('client_name', 'client name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_subject', 'email subject', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run())
		{
			$invoice_id 	= $this->input->post('invoice_id');
			$email_subject 	= $this->input->post('email_subject');
			
			$email_sent = $this->send_invoice($invoice_id, $email_subject);
			
			if($email_sent)
			{
				$this->session->set_flashdata('success', 'The invoice has been emailed successfully !!');
				$response = array(
					'success'           => 1,
				);
			}
			else
			{
				$response = array(
					'success'           => 0,
				);
				show_error($this->email->print_debugger());
			}
		}
		else
		{
			$this->load->helper('json_error');
				$response = array(
					'success'           => 0,
					'validation_errors' => json_errors()
				);
			
		}
		echo json_encode($response);
	}
	function viewpdf($invoice_id)
	{
		$data 		  = array();
		$data['title'] 	 = $this->title;
		
		$invoice_details = $this->invoice_model->previewinvoice($invoice_id);
		$this->load->helper('pdf');
		$pdf_invoice = generate_pdf_invoice($invoice_details, true, NULL);
	}
	
	
	function send_invoice($invoice_id = 0, $email_subject = '')
	{
		$data = array();
		$invoice_data = $this->invoice_model->get_invoice_data($invoice_id);
		$invoice_details = $this->invoice_model->previewinvoice($invoice_id);
		$this->load->helper('pdf');
		$pdf_invoice = generate_pdf_invoice($invoice_details, false, NULL);
		$data['invoice'] = $invoice_data;
		$business = get_business_config();
		$company_name = ( $business->business_name != '') ? $business->business_name : "PayByLink.RU";
		$message_body = $this->load->view('email_templates/paylink', $data, TRUE);
		
		$this->load->library("email");
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from("noreply@paybylink.ru", $invoice_data->shop_name);
		$this->email->to($invoice_data->client_email);
		$this->email->subject($email_subject);
		$this->email->message($message_body);
		
		//mail("ant1freezeca@gmail.com", $email_subject, $message_body); 
			
		$this->email->attach($pdf_invoice);
		$response = ($this->email->send()) ? true : false ;
		return $response;
	}	
	
}