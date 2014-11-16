<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pay extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
		$this->load->model('payment_model');
	}
	
	public function index($invoice_id = 0, $payment_method = ''){
		
		$invoice = $this->invoice_model->get_invoice_data($invoice_id);
		
		$payment_details = array(
			'invoice_id' => $invoice_id,
			'payment_method' => $payment_method,
			'payment_amount' => $invoice->invoice_balance,
			'payment_note' => 'Yandex money payment',
			'payment_date' => date('Y/m/d'),
			'payment_status' => 'pending',
		);
		
		$payment_id = $this->payment_model->yandex_pay($payment_details);
		
		$this->load->library('yandex');
		$this->yandex->add_field('ShopID', $invoice->payment_shop_id);
		$this->yandex->add_field('scid', $invoice->scid);
		$this->yandex->add_field('Sum',  $invoice->invoice_balance); // sum
		$this->yandex->add_field('customerNumber',  $invoice->invoice_id);
		$this->yandex->add_field('paymentType', $payment_method); 
		$this->yandex->add_field('orderNumber', $payment_id); 
		$this->yandex->add_field('cps_phone', $invoice->client_phone);
		$this->yandex->add_field('cps_email', $invoice->client_email);
		$this->yandex->add_field('MyField', $invoice->invoice_id);
		$this->yandex->add_field('p_type', 'invoice_payment');
		
		if($payment_id)
		$this->yandex->submit_yandex_post(); // submit the fields to yandex
	}
	
	public function checkorder(){
	
		$fp = fopen('assets/yandex_u4t3y2oi9n84ynt.log', 'a+');
		$str=date('Y-m-d H:i:s').' - check - ';
		foreach ($_POST as $vn=>$vv) {
		  $str.=$vn.'='.$vv.';';
		}
		fwrite($fp, $str."\n");
		fclose($fp);
		
		$this->load->model('shop_model');
		$shop = $this->shop_model->shop_details($_POST['shopId']);
		$hash = md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$shop->shoppw);		
		if (strtolower($hash) != strtolower($_POST['md5'])) 
		{ 
			$code = 1;//temp
			$answer = '<?xml version="1.0" encoding="UTF-8"?> <checkOrderResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
			
			$fp = fopen('assets/response_85y23pd84ypy.log', 'a+');
			$str=date('Y-m-d H:i:s').' - check answer - '.$answer.' - '.$hash. ' - '.$_POST['md5'];
			fwrite($fp, $str."\n"); fclose($fp);
			
			print '<?xml version="1.0" encoding="UTF-8"?>';
			print '<checkOrderResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
		}
		else {
			$code = 0;
			$answer = '<?xml version="1.0" encoding="UTF-8"?> <checkOrderResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
			
			$fp = fopen('assets/response_85y23pd84ypy.log', 'a+');
			$str=date('Y-m-d H:i:s').' - check answer - '.$answer.' - '.$hash. ' - '.$_POST['md5'];
			fwrite($fp, $str."\n"); fclose($fp);
			
			print '<?xml version="1.0" encoding="UTF-8"?>';
			print '<checkOrderResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
		}
	}
	
	public function paymentaviso(){
		
		$fp = fopen('assets/yandex_u4t3y2oi9n84ynt.log', 'a+');
		$str=date('Y-m-d H:i:s').' - aviso - ';
		foreach ($_POST as $vn=>$vv) {
		  $str.=$vn.'='.$vv.';';
		}
		fwrite($fp, $str."\n");
		fclose($fp);
		
		$this->load->model('shop_model');
		$shop = $this->shop_model->shop_details($_POST['shopId']);
		$hash = md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$shop->shoppw);		
		if (strtolower($hash) != strtolower($_POST['md5'])) 
		{ 
			$code = 1;
					$answer = '<?xml version="1.0" encoding="UTF-8"?> <paymentAvisoResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
					
					$fp = fopen('assets/response_85y23pd84ypy.log', 'a+');
					$str=date('Y-m-d H:i:s').' - aviso answer - '.$answer.' - '.$hash. ' - '.$_POST['md5'];
					fwrite($fp, $str."\n"); fclose($fp); 
					
					print '<?xml version="1.0" encoding="UTF-8"?>';
					print '<paymentAvisoResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="1" invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
		
		}
		else {
			$code = 0;
					$p_type = $_POST['p_type'];
					if($p_type == 'invoice_payment'){
						$payment_id 	= $_POST['orderNumber'];
						$invoice_id 	= $_POST['MyField'];
						$payment_status = array('payment_status'=>'completed');
						$this->payment_model->update_payment($payment_id, $payment_status);
						$this->invoice_model->invoice_status($invoice_id);
						
						mail($shop->shop_email, "Счет с номером ".$invoice_id." был оплачен.", "Счет с номером ".$invoice_id." на сумму ".$_POST['orderSumAmount']." был оплачен."); 
						
					}
					else{
						$payment_details = array(
							'paymentDatetime' 		=> $_POST['paymentDatetime'],
							'shopSumBankPaycash' 	=> $_POST['shopSumBankPaycash'],
							'requestDatetime' 		=> $_POST['requestDatetime'],
							'merchant_order_id' 	=> $_POST['merchant_order_id'],
							'customerNumber' 		=> $_POST['customerNumber'],
							'MyField' 				=> $_POST['MyField'],
							'sumCurrency' 			=> $_POST['sumCurrency'],
							'shopSumAmount' 		=> $_POST['shopSumAmount'],
							'ErrorTemplate' 		=> $_POST['ErrorTemplate'],
							'shopSumCurrencyPaycash' => $_POST['shopSumCurrencyPaycash'],
							'orderSumAmount' 		=> $_POST['orderSumAmount'],
							'shn' 					=> $_POST['shn'],
							'shopId' 				=> $_POST['shopId'],
							'action' 				=> $_POST['action'],
							'shopArticleId' 		=> $_POST['shopArticleId'],
							'orderSumCurrencyPaycash' => $_POST['orderSumCurrencyPaycash'],
							'skr_sum' 				=> $_POST['skr_sum'],
							'orderSumBankPaycash' 	=> $_POST['orderSumBankPaycash'],
							'external_id' 			=> $_POST['external_id'],
							'invoiceId' 			=> $_POST['invoiceId'],
							'paymentType' 			=> $_POST['paymentType'],
							'orderCreatedDatetime' => $_POST['orderCreatedDatetime'],
							'paymentPayerCode' 		=> $_POST['paymentPayerCode'],
							'rebillingOn' 			=> $_POST['rebillingOn'],
							'depositNumber' 		=> $_POST['depositNumber'],
							'yandexPaymentId' 		=> $_POST['yandexPaymentId'],
							'skr_env' 				=> $_POST['skr_env'],
							'orderNumber' 			=> $_POST['orderNumber'],
							'payment_status' 		=> 'completed',
						);
						$payment_id = $_POST['orderNumber'];
						$usershopid = $_POST['shopId'];
						$invoice_id = $_POST['MyField'];
						$orderSumAmount = $_POST['orderSumAmount'];
						
						$this->payment_model->update_transaction($payment_id, $payment_details);
						if( $usershopid == "17073"){
						mail($shop->shop_email, "Счет с номером ".$invoice_id." был оплачен.", "Счет с номером ".$invoice_id." на сумму ".$orderSumAmount." был оплачен."); 
						}
					}
					
					$answer = '<?xml version="1.0" encoding="UTF-8"?> <paymentAvisoResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
					
					$fp = fopen('assets/response_85y23pd84ypy.log', 'a+');
					$str=date('Y-m-d H:i:s').' - aviso answer - '.$answer.' - '.$hash. ' - '.$_POST['md5'];
					fwrite($fp, $str."\n"); fclose($fp);
			
					print '<?xml version="1.0" encoding="UTF-8"?>';
					print '<paymentAvisoResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="0" invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $_POST['shopId'] .'"/>';
				
				
		
				
				
				}
	}
	
	public function success(){
		header('Location: http://hubpay.ru');
		die();
	}
	
	public function fail(){
		header('Location: http://hubpay.ru');
		die();
	}
}