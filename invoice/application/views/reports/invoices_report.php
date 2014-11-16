<?php
$config = get_business_config();
$currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' $ ';
?>
<div class="row">
<div class="col-lg-3">
	<div class="form-group">
		<label>Client : </label>
		<select name="client_id" id="client_id" class="form-control">
		<?php echo $clients; ?>
		</select>
	</div>
</div>

<div class="col-lg-3">
	<label> </label>
	<div class="form-group input-group" style="margin-left:0;">
	<a href="javascript: void(0);" onclick="javascript: invoices_report();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_save_invoice"><i class="fa fa-check"></i> Generate Report </a>
	</div>
</div>
</div>

	<table class="table table-hover table-striped table-bordered ">
	<thead>
	  <tr class="table_header">
		<th>STATUS</th>
		<th>INVOICE NUMBER</th>
		<th>CLIENT</th>
		<th class="text-right">AMOUNT</th>
		<th></th>
	  </tr>
	</thead>
	<tbody>
<?php
if( isset($invoices_report) && !empty($invoices_report))
{
?>
	<?php
	foreach ($invoices_report as $count => $invoice)
	{
	?>
	  <tr class="transaction-row">
		<td>
		<?php 
		if($invoice['invoice_status'] == 'PAID'){ $class='success'; } 
		if($invoice['invoice_status'] == 'UNPAID'){ $class='warning'; } 
		if($invoice['invoice_status'] == 'CANCELLED'){ $class='danger'; } 
		if($invoice['invoice_status'] == 'PARTIALLY PAID'){ $class='info'; } 
		?>
		<span class="label label-<?php echo $class;?>"><?php echo $invoice['invoice_status'];?></span></td>
		<td><a href="<?php echo site_url('invoices/edit/');?>/<?php echo $invoice['invoice_id'];?>"><?php echo $invoice['invoice_number'];?></a></td>
		<td><?php echo ucwords($invoice['invoice_client']);?></td>
		<td class="text-right"><?php echo $currency_symbol.number_format($invoice['invoice_amount'], 2); ?></td>
		<td>
		<a href="<?php echo site_url('invoices/edit/');?>/<?php echo $invoice['invoice_id'];?>" class="btn btn-xs btn-primary"><i class="fa fa-check"> View / Edit </i></a>
		</td>
	  </tr>
	<?php
	}
}
else
{
?>
<tr class="no-cell-border transaction-row">
<td colspan="7"> There are no records to display at the moment.</td>
</tr>
<?php
}
?>
</tbody>
</table>