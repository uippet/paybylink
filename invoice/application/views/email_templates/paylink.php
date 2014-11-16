<?php 
$config = get_business_config();
$this->config->currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' P ';
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<body style="margin:0; padding:0;">
	<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;background-color:#F8F8F8;background-image: url(<?=base_url();?>assets/img/email_template/bg_texture.png);" align="center">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" width="640" style="border-collapse:collapse;" align="center">
					<tr><td height="60"/></tr>
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="640" style="border-collapse: collapse;">
								<tr>
									<td width="5"/>
									<td>
										<table cellpadding="0" cellspacing="0" width="632" style="border-collapse: collapse;">
											<tr>
												<td height="1" bgcolor="#E7E7E7" colspan="3"/>
											</tr>
											<tr>
												<td width="1" bgcolor="#E7E7E7"/>
												<td bgcolor="#FFFFFF" style="padding-top:30px;padding-right:0px;padding-bottom:20px;padding-left:0px;">
													<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
														<tr>
															<td colspan="3" align="center">
																<!--<h1 style="margin-top:0;margin-bottom:20px;font-weight:normal;font-family:Arial;font-size:20px;color:#000000;">
																	К оплате: <?php //echo $invoice->invoice_balance.' '.$this->config->currency_symbol; ?>
																</h1>-->
															</td>
														</tr>
														<tr>
															<td width="100"/>
															<td width="420">
																<p style="color:#444444;font-family:Arial;font-size:14px;line-height:19px;margin-top:0;margin-bottom:8px;">Здравствуйте, <?php echo $invoice->client_name; ?></p>
																<p style="color:#444444;font-family:Arial;font-size:14px;line-height:19px;margin-top:0;margin-bottom:8px;">
																	 <?php echo $invoice->shop_name; ?> благодарит вас за оформленный заказ и просит проверить его содержание.
																</p>
																<p style="color:#444444;font-family:Arial;font-size:14px;line-height:19px;margin-top:0;margin-bottom:8px;">
																	<b>В вашем заказе:</b>
																	<?php foreach ($invoice->invoice_items as $item ) : ?>
																	<p>  <?php echo $item['item_name']; ?> - <?php echo $item['item_total'].' '.$this->config->currency_symbol; ?></p>
																	<?php endforeach; ?>
																	<b>Сумма заказа:</b> <?php echo $invoice->invoice_balance.' '.$this->config->currency_symbol; ?>
																</p>
															</td>
															<td width="100"/>
														</tr>
														<tr>
															<td width="630" colspan="3">
																<p style="text-align: center;margin-top:45px">
																	<img width="630" height="3" alt="" src="<?=base_url();?>assets/img/email_template/m_separator.png">
																</p>
															</td>
														</tr>
														<tr>
															<td colspan="3" align="center">
																<h1 style="margin-top:30;margin-bottom:30px;font-weight:normal;font-family:Arial;font-size:20px;color:#000000;">
																	Итоговая сумма: <?php echo $invoice->invoice_balance.' '.$this->config->currency_symbol; ?>
																</h1>
																<p>Выберите удобный для вас способ оплаты</p>
																<?php if($invoice->credit_card) : ?>	
																<p style="text-align: center;margin-top:20px">
																	<a href="<?php echo site_url('pay/index/'.$invoice->invoice_id.'/AC')?>" title="Банковской картой" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/cards.png"></a>
																</p>
																<?php endif; ?>
																<?php if($invoice->ymoney) : ?>	
																<p style="text-align: center;margin-top:20px">
																	<a href="<?php echo site_url('pay/index/'.$invoice->invoice_id.'/PC')?>" title="С помощью Яндекс.Денег" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/yamoney.png"></a>
																</p>
																<?php endif; ?>
																<?php if($invoice->mobile_phone) : ?>
																<p style="text-align: center;margin-top:20px">
																	<a href="<?php echo site_url('pay/index/'.$invoice->invoice_id.'/MC')?>" title="С мобильного телефона" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/mobile.png"></a>
																</p>
																<?php endif; ?>
																<?php if($invoice->kiosks) : ?>
																<p style="text-align: center;margin-top:20px">
																	<a href="<?php echo site_url('pay/index/'.$invoice->invoice_id.'/GP')?>" title="Наличными через терминал" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/cash.png"></a>
																</p>
																<?php endif; ?>
																<?php if($invoice->webmoney) : ?>
																<p style="text-align: center;margin-top:20px;margin-bottom:30px">
																	<a href="<?php echo site_url('pay/index/'.$invoice->invoice_id.'/WM')?>" title="С помощью Webmoney" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/webmoney.png"></a>
																</p>
																<?php endif; ?>
														</tr>
															</td>
														</tr>
													</table>
												</td>
												<td width="1" bgcolor="#E7E7E7"/>
											</tr>
										</table>
									</td>
									<td width="3"/>
								</tr>
								<tr><td colspan="3"><img src="<?=base_url();?>assets/img/email_template/shadow.png" width="640" height="16" alt=""/></td></tr>
							</table>
						</td>
					</tr>
					<tr><td height="50"/></tr>
				</table>
			</td>
		</tr>
	</table>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52109863-1', 'paybylink.ru');
  ga('send', 'pageview');

</script>
</body>