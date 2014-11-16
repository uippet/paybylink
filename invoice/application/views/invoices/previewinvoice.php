<?php 
$config = get_business_config();
$currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' RUB ';
?>
<script type="text/javascript">
$(function()
{
$('#modal-view-invoice').modal('show');
$('html').click(function() {
    $('#modal-view-invoice').modal('hide');
});
});
</script>
<div class="modal" id="modal-view-invoice" style="width:1000px;left:40%;font-size:11px">
<div class="modal-header">
	<a data-dismiss="modal" class="close">&times;</a>
	<label class="control-ccclabel">Просмотр счета : #<?php echo $invoice_details['invoice_details']->invoice_number; ?> </label>
</div>
<div class="modal-body">
<div class="row">
<div class="col-lg-12">
	<div class="col-lg-6">
		<?php 
		$invoice_id = $invoice_details['invoice_details']->invoice_id;
		$shop = invoice_shop_details($invoice_id);

		if($shop->shop_logo != ''){
		?>
		<img src="<?php echo base_url().UPLOADSDIR.$shop->shop_logo;?>" width="50%"/>
		<?php
		}
		?>
	</div>
	<div class="col-lg-6">
		<h2> Счет # <?php echo $invoice_details['invoice_details']->invoice_number; ?></h2><hr/>
		<h4><?php echo $shop->shop_name; ?></h4>
		<p><?php  echo $shop->shop_address; ?></p>
		<p><?php  echo $shop->shop_phone; ?></p>
		<p><?php  echo $shop->shop_description; ?></p>
	</div>
</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-12">
	<div class="client-details">
		<div class="row">
			<div class="col-lg-12">
			<h4>Клиент : <?php echo $invoice_details['invoice_details']->client_name; ?></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<h5>Адрес&nbsp;&nbsp; : <?php echo $invoice_details['invoice_details']->client_address; ?></h5>
				<h5>Телефон &nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $invoice_details['invoice_details']->client_phone; ?></h5>					
				<h5>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $invoice_details['invoice_details']->client_email; ?></h5>	
			</div>
			<div class="col-lg-6 text-right">
			<h4><label> К оплате </label></h4>
			<h4 class="invoice_amount_due"><label>
			<?php 
			
			echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_subtotal'] + $invoice_details['invoice_totals']['items_taxes_total'] - $invoice_details['invoice_totals']['total_payments_received'] - $invoice_details['invoice_details']->invoice_discount, 2);
			
			?>
			</label></h4>
			</div>
		</div>
		</div>
	</div>
</div>
<hr/>
<div class="row">
<div class="col-lg-12">
<table class="table">
	<thead>
	  <tr class="table_header">
		<th>Название товара или услуги</th>
		<th>Описане</th>
		<th>Количество</th>
		<th class="text-right">Цена за штуку</th>
		<th class="text-right">Скидка</th>
		<th class="text-right">Стоимость позиции</th>
	  </tr>
	</thead>
	<tbody>
	<?php
	foreach ($invoice_details['invoice_items'] as $count=>$item)
	{?>
	<tr class="transaction-row">
	<td><?php echo $item['item_name'];?></td>
	<td style="width: 30%"><?php echo $item['item_description'];?></td>
	<td><?php echo $item['item_quantity'];?></td>
	<td class="text-right" style="width: 10%"><?php echo $currency_symbol.number_format($item['item_price'], 2); ?></td>
	<td class="text-right" style="width: 10%"><?php echo $currency_symbol.number_format($item['item_discount'], 2); ?></td>
	<td class="text-right" style="width: 10%"><?php echo $currency_symbol.number_format($item['item_price']*$item['item_quantity']-$item['item_discount'], 2); ?></td>
	</tr>
	<?php
	}
	?>
	<tr><td colspan="5" class="text-right ">Общая стоимость заказа : </td><td class="text-right"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_subtotal']+$invoice_details['invoice_totals']['items_discount_total'], 2);?></label></td></tr>

	<tr><td colspan="5" class="text-right no-border">Скидка по позициям : </td><td class="text-right"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_discount_total'], 2);?></label></td></tr>
	<tr><td colspan="5" class="text-right no-border">Скидка на заказ : </td><td class="text-right no-border"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_details']->invoice_discount, 2);?></label></td></tr>

	<tr><td colspan="5" class="text-right no-border">Оплачено : </td><td class="text-right no-border invoice_amount_paid"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['total_payments_received'], 2);?></label></td></tr>
	<tr><td colspan="5" class="text-right no-border">К оплате : </td><td class="text-right invoice_amount_due"><label><?php echo $currency_symbol.number_format($invoice_details['invoice_totals']['items_subtotal'] +$invoice_details['invoice_totals']['items_taxes_total'] - $invoice_details['invoice_totals']['total_payments_received']-$invoice_details['invoice_details']->invoice_discount , 2);?></label></td>
	</tr>
<tr class="table_header"><td colspan="7"></td></tr>
<tr><td colspan="5">
<h4>Комментарий </h4>
<?php echo $invoice_details['invoice_details']->invoice_terms; ?>
<hr/>
</td></tr>
</div>
</div>
</div>
</div>

<style>
.client-details {
border: 1px dotted #CCC;
font-size: 12px;
background-color: #d9edf7;
padding: 10px 15px;
}
</style>
