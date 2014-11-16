<?php 
$config = get_business_config();
$currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' RUB ';
?>
<link href="<?php echo base_url().CSSFOLDER; ?>style.css" rel="stylesheet"/>
<style>
table {
border-collapse: collapse;
border-spacing: 0;
width:100%;
}
.table-bordered td, .table-bordered th{
border: 1px solid #dddddd;
padding: 8px;
border-collapse: collapse;
}
body {
font-size: 75%;
}
</style>
<div class="row">
	<div class="col-lg-12">
	<table width="100%">
	<tr><td>
			<?php 
			$invoice_id = $invoice_details['invoice_details']->invoice_id;  
			$shop = invoice_shop_details($invoice_id);
			if($shop->shop_logo != ''){
			?>
			<img src="<?php echo base_url().UPLOADSDIR.$shop->shop_logo;?>" width="30%"/>
			<?php
			}
			?>
			</td>
			<td>
			<?php
			 $class = ($invoice_details['invoice_details']->invoice_status == 'UNPAID') ? 'invoice_status_cancelled' : 'invoice_status_paid';
			  ?>
			<div class="<?php echo $class; ?>"> <?php echo $invoice_details['invoice_details']->invoice_status; ?></div>
			</td>
			</tr>
	</table>
	</div>
	
	
</div>
<hr/>
<div class="row">
	<div class="col-lg-12">
	<table width="100%">
	<tr><td>Поставщик : </td><td><p>Покупатель : </p></td></tr>
	<tr><td style="width: 50%;">
		<h4><?php echo $shop->shop_name; ?></h4>
		<p><?php  echo $shop->shop_address; ?></p>
		<p><?php  echo $shop->shop_phone; ?></p>
		<p><?php  echo $shop->shop_description; ?></p>
	</td><td>
		<h4><?php echo $invoice_details['invoice_details']->client_name; ?></h4>
		<p><?php echo $invoice_details['invoice_details']->client_address; ?></p>
		<p><?php echo $invoice_details['invoice_details']->client_phone; ?></p>					
		<p><?php echo $invoice_details['invoice_details']->client_email; ?></p>	
	</td></tr><tr>
	<td><h4> Номер счета. <?php echo $invoice_details['invoice_details']->invoice_number; ?></h4></td>
	<td><h4> Дата выставления счета : <?php echo date('d/m/Y'); ?></h4></td>
	</tr>
	</table>
	</div>
</div>
<div class="row">
<div class="col-lg-12">
<table class="table table-bordered">
	<thead>
	  <tr class="table_header">
		<th>Название</th>
		<th>Описание</th>
		<th>Количество</th>
		<th class="text-right">Цена за 1 шт.</th>
		<th class="text-right">Скидка</th>
		<th class="text-right">Подитог</th>
	  </tr>
	</thead>
	<tbody>
	<?php
	foreach ($invoice_details['invoice_items'] as $count=>$item)
	{?>
	<tr class="transaction-row">
	<td><?php echo $item['item_name'];?></td>
	<td><?php echo $item['item_description'];?></td>
	<td style="text-align:center"><?php echo $item['item_quantity'];?></td>
	<td class="text-right" style="width: 13%"><?php echo number_format($item['item_price'], 2); ?></td>
	<td class="text-right" style="width: 10%"><?php echo number_format($item['item_discount'], 2); ?></td>
	<td class="text-right" style="width: 14%"><?php echo number_format($item['item_price']-$item['item_discount'], 2); ?></td>
	</tr>
	<?php
	}
	?>
	
	
	
	<tr><td colspan="5" class="text-right">Общая стоимость заказа : </td><td class="text-right"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_subtotal'], 2);?></label></td></tr>
	<tr><td colspan="5" class="text-right no-border">Общая скидка : </td><td class="text-right"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_discount_total'], 2);?></label></td></tr>
	<tr><td colspan="5" class="text-right no-border">Скидка на заказ : </td><td class="text-right no-border"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_details']->invoice_discount, 2);?></label></td></tr>

	<tr><td colspan="5" class="text-right no-border">Всего оплаченно : </td><td class="text-right no-border invoice_amount_paid"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['total_payments_received'], 2);?></label></td></tr>
	<tr><td colspan="5" class="text-right no-border">К оплате : </td><td class="text-right invoice_amount_due"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_subtotal'] +$invoice_details['invoice_totals']['items_taxes_total'] - $invoice_details['invoice_totals']['total_payments_received']-$invoice_details['invoice_details']->invoice_discount , 2);?></label></td>
	</tr>
	
	
	<tr class="table_header"><td colspan="6"></td></tr>
	</table>
	<h4>Примечания </h4>
	<i><?php echo $invoice_details['invoice_details']->invoice_terms; ?></i>
	<br/><br/>
	<label class="control-label">Покупатель : <?php echo $invoice_details['invoice_details']->client_name; ?></label>
	<br/><br/><br/>
	................................................<br/>
	<i>Подпись и печать</i>
</div>
</div>

