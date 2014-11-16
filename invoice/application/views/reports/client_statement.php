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
	<a href="javascript: void(0);" onclick="javascript: client_statement();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_save_invoice"><i class="fa fa-check"></i> Generate Statement </a>
	</div>
</div>
</div>

<?php
if(isset($stats)){?>
<div class="row">
	<div class="col-lg-5">
	<table class="table table-bordered tablesorter">
		<thead><tr class="table_header"><th>Client's Pending Balance</th></tr></thead>
		<tbody>
		<tr><td class="statistics_cell"><?php 
		$balance = (isset($stats)) ? number_format($stats['total_invoiced'] - $stats['total_received'], 2) : ''; 
		$bal_class = ($balance > 0) ? 'pending_bal' : 'over_paid';
		?>
		<span class="<?php echo $bal_class; ?>"><?php echo $currency_symbol.$balance; ?></span>
		</td></tr>
		</tbody>
	</table>
	</div>
	<div class="col-lg-5 pull-right">
	<table class="table  table-bordered ">
		<thead><tr class="table_header"><th colspan="2">Client's Statistics</th></tr></thead>
		<tbody>
		<tr class="transaction-row"><td width="50%">Total Amount Invoiced </td> 
		<td><?php echo $currency_symbol; ?><?php echo (isset($stats)) ? number_format($stats['total_invoiced'],2) : ''; ?></td></tr>
		<tr class="transaction-row"><td>Total Amount Paid </td>
		<td><?php echo $currency_symbol; ?><?php echo (isset($stats)) ? number_format($stats['total_received'], 2) : ''; ?></td></tr>
		</tbody>
	</table>
	</div>
</div>
<?php } ?>
	<table class="table table-hover table-striped table-bordered ">
	<thead>
	  <tr class="table_header">
		<th>ACTIVITY</th>
		<th class="text-right">INVOICES</th>
		<th class="text-right">PAYMENTS</th>
		<th class="text-right">BALANCE</th>
	  </tr>
	</thead>
	<tbody>
<?php
if( isset($statement_details) && !empty($statement_details))
{
?>
	<?php
	$total = 0;
	foreach ($statement_details as $count => $statement)
	{
		$total = ($statement['transaction_type'] == 'payment') ? $total - $statement['amount'] : $total + $statement['amount'];
	?>
	  <tr class="transaction-row <?php echo ($statement['transaction_type'] == 'payment') ? 'payment-row' : 'invoice-row';?>">
		<td><?php echo $statement['activity'];?></td>
		<td class="text-right"><?php echo ($statement['transaction_type'] != 'payment') ? $currency_symbol.number_format($statement['amount'], 2) : '';?></td>
		<td class="text-right"><?php echo ($statement['transaction_type'] == 'payment') ? $currency_symbol.number_format($statement['amount'], 2) : '';?></td>
		<td class="text-right balance"><?php echo $currency_symbol.number_format($total, 2); ?></td>
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