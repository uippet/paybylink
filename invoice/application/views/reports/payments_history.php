<script type="text/javascript">
    $(function()
    {
		$('.date').datepicker( {autoclose: true, format: 'dd-mm-yyyy'} );
		$(".date").datepicker("setDate", new Date());
	});
</script>
<div class="row">
<div class="col-lg-3">
	<label>From : </label>
	<div class="form-group input-group date" style="margin-left:0;">
	   <input class="form-control" size="16" type="text" name="from_date" readonly id="from_date"/>
		<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
	</div>
</div>

<div class="col-lg-3">
	<label>To : </label>
	<div class="form-group input-group date" style="margin-left:0;">
	   <input class="form-control" size="16" type="text" name="to_date" readonly id="to_date"/>
		<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
	</div>
</div>
<div class="col-lg-3">
	<label> </label>
	<div class="form-group input-group" style="margin-left:0;">
	<a href="javascript: void(0);" onclick="javascript: payments_history();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_save_invoice"><i class="fa fa-check"></i> Generate Report </a>
	</div>
</div>
</div>
<div class="row">
	<div class="col-lg-12">
	<p><span class="bold-text" >Payments History</span></p>
	</div>
</div>
	<table class="table table-hover table-striped table-bordered">
	<thead>
	  <tr class="table_header">
		<th>DATE </th>
		<th>CLIENT</th>
		<th>EMAIL</th>
		<th>PHONE</th>
		<th class="text-right">STATUS</th>
		<th class="text-right">AMOUNT</th>
		
	  </tr>
	</thead>
	<tbody>
<?php
$config = get_business_config();
$currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' $ ';
if( isset($payments) && $payments->num_rows()>0)
{
?>
	<?php
	$total = 0;
	foreach ($payments->result_array() as $count => $payment)
	{
	?>
	  <tr class="transaction-row">
		<td><?php echo date('d-m-Y', strtotime($payment['paymentDatetime']));?></td>
		<td><?php echo ucwords($payment['name']);?></td>
		<td><?php echo ucwords($payment['email']);?></td>
		<td><?php echo ucwords($payment['phone']);?></td>
		<td class="text-right"><span class="label label-<?php echo ($payment['payment_status'] == 'pending') ? 'danger' : 'success' ; ?>"><?php echo $payment['payment_status'] ; ?></span></td>
	  	<td class="text-right"><?php echo $currency_symbol.number_format($payment['sum'], 2); ?></td>
	  </tr>
	<?php
		$total = $total + $payment['sum'];
	}
	?>
	<tr class="active">
	<td>TOTAL ( <?php echo $currency_symbol;?>)</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class="text-right"><?php echo $currency_symbol.number_format($total, 2); ?></td>
	</tr>
<?php
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