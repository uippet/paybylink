<?php
$countries = config_item('country_list');
$symbol = get_setting_value('currency');
$currency_symbol = (!empty($symbol) && $symbol->config_value !='') ? $symbol->config_value.' ' : ' $ ';
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
			<?php $logo = get_setting_value('companylogo');
			if($logo->config_value != ''){
			?>
			<img src="<?php echo base_url().UPLOADSDIR.$logo->config_value;?>" width="30%"/>
			<?php
			}
			?>
			</td>
			</tr>
	</table>
	</div>
	
</div>
<hr/>
<div class="row">
	<div class="col-lg-12">
	<table width="100%">
	<tr><td>From : </td><td><p>To : </p></td></tr>
	<tr><td>
		<h4><?php $name = get_setting_value('companyname');  echo $name->config_value; ?></h4>
		<p><?php $address = get_setting_value('companyaddress');  echo $address->config_value; ?></p>
		<p><?php $telephone = get_setting_value('companyphone');  echo $telephone->config_value; ?></p>
		<p><?php $companyemail = get_setting_value('companyemail');  echo $companyemail->config_value; ?></p>
		<p><?php $companywebsite = get_setting_value('companywebsite');  echo $companywebsite->config_value; ?></p>
	</td><td>
		<h4><?php echo $quote_details['quote_details']->client_name; ?></h4>
		<p><?php echo $quote_details['quote_details']->client_address; ?></p>
		<p><?php echo $quote_details['quote_details']->client_phone; ?></p>					
		<p><?php echo $quote_details['quote_details']->client_email; ?></p>	
		<p><?php echo $countries [$quote_details['quote_details']->client_country]; ?>.</p>	
	</td></tr><tr>
	<td><h4> Subject : <?php echo $quote_details['quote_details']->quote_subject; ?></h4></td>
	<td><h4> Quote Date : <?php echo date('d/m/Y', strtotime($quote_details['quote_details']->date_created)); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Valid Until : <?php echo date('d/m/Y', strtotime($quote_details['quote_details']->valid_until)); ?></h4></td>
	</tr>
	</table>
	</div>
</div>
<div class="row">
<div class="col-lg-12">
<table class="table table-bordered">
	<thead>
	  <tr class="table_header">
		<th>ITEM</th>
		<th>DESCRIPTION</th>
		<th>TAX </th>
		<th>QUANTITY</th>
		<th class="text-right">UNIT PRICE</th>
		<th class="text-right">DISCOUNT</th>
		<th class="text-right">SUB TOTAL</th>
	  </tr>
	</thead>
	<tbody>
	<?php
	foreach ($quote_details['quote_items'] as $count=>$item)
	{?>
	<tr class="transaction-row">
	<td><?php echo $item['item_name'];?></td>
	<td><?php echo $item['item_description'];?></td>
	<td><?php echo ($item['Item_tax_rate_id'] !=0 ) ? $item['tax_rate_name'].' - '.$item['tax_rate_percent'].'%' : '0.00%';?></td>
	<td style="text-align:center"><?php echo $item['item_quantity'];?></td>
	<td class="text-right" style="width: 13%"><?php echo number_format($item['item_price'], 2); ?></td>
	<td class="text-right" style="width: 10%"><?php echo number_format($item['item_discount'], 2); ?></td>
	<td class="text-right" style="width: 14%"><?php echo number_format($item['item_price']*$item['item_quantity']-$item['item_discount'], 2); ?></td>
	</tr>
	<?php
	}
	?>
	
	
	
	<tr><td colspan="6" class="text-right">ITEMS SUB TOTAL : </td><td class="text-right"><label><?php echo $currency_symbol.number_format($quote_details['quote_totals']['items_subtotal'], 2);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">QUOTE DISCOUNT : </td><td class="text-right no-border"><label><?php echo $currency_symbol.number_format($quote_details['quote_details']->quote_discount, 2);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">NEW SUB TOTAL : </td><td class="text-right invoice_amount_due"><label><?php echo $currency_symbol.number_format($quote_details['quote_totals']['items_subtotal'] - $quote_details['quote_details']->quote_discount, 2);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">TOTAL TAX : </td><td class="text-right no-border"><label><?php echo $currency_symbol.number_format($quote_details['quote_totals']['items_taxes_total'], 2);?></label></td></tr>
		

	<tr><td colspan="6" class="text-right no-border">AMOUNT DUE : </td><td class="text-right invoice_amount_due"><label><?php echo $currency_symbol.number_format($quote_details['quote_totals']['items_subtotal'] + $quote_details['quote_totals']['items_taxes_total'] - $quote_details['quote_details']->quote_discount , 2);?></label></td>
	</tr>
	
	
	<tr class="table_header"><td colspan="7"></td></tr>
	</table>
	<h4>Quote Terms </h4>
	<i><?php echo $quote_details['quote_details']->customer_notes; ?></i>
	<br/><br/>
</div>
</div>

