 <?php
	if( isset($invoices) && !empty($invoices))
	{
		foreach ($invoices as $count => $invoice)
		{
		
		?>
		<tr>
		<td>
		<?php 
		if($invoice['invoice_status'] == 'PAID'){ $class='success'; } 
		if($invoice['invoice_status'] == 'UNPAID'){ $class='warning'; } 
		if($invoice['invoice_status'] == 'CANCELLED'){ $class='danger'; } 
		?>
		<span class="label label-<?php echo $class;?>"><?php echo $invoice['invoice_status'];?></span>
		</td>
		<td><a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>"><?php echo $invoice['invoice_number']; ?></a></td>
		<td><a href="<?php echo site_url('clients/editclient/'.$invoice['client_id']); ?>"><?php echo ucwords($invoice['client_name']); ?></a></td>
		<td class="text-right"><?php 
		$config = get_business_config();
		$currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' $ ';
		echo $currency_symbol.number_format($invoice['invoice_amount'], 2); ?></td>
		<td style="width:32%">
		<a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>" class="btn btn-xs btn-primary"><i class="fa fa-check"> Изменить </i></a>
		<a href="javascript:;" class="btn btn-info btn-xs" onclick="viewInvoice('<?php echo $invoice['invoice_id']; ?>')"><i class="fa fa-search"> Предпросмотр </i></a>
		<a href="<?php echo site_url('invoices/viewpdf');?>/<?php echo $invoice['invoice_id']; ?>" class="btn btn-warning btn-xs"> PDF </a>
		<!--<a href="#" class="btn btn-xs btn-primary"><i class="fa fa-arrow-right"> Refund </i></a>-->
		</td>
		</tr>
		<?php
		}
	}
	else
	{
	?>
	<tr class="no-cell-border">
	<td colspan="7"> Тут пока нет <?php echo $status; ?> счетов нв этот момент.</td>
	</tr>
	<?php
	}
	?>