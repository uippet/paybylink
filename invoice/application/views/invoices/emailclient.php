<script type="text/javascript">
$(function()
{
$('#modal-email-client').modal('show');
});
</script>
<div class="modal" id="modal-email-client" style="width:510px;left:50%;font-size:11px">
<div class="modal-header">
	<a data-dismiss="modal" class="close">&times;</a>
	<label class="control-label">Email по счету : #<?php echo $invoice_details->invoice_number; ?> </label>
</div>
<div class="modal-body">
<div class="row">
<div class="col-lg-12">
	<form class="form-horizontal">
	<div class="col-lg-12">
		<input type="hidden" id="invoice_id" name="invoice_id" value="<?php echo $invoice_details->invoice_id; ?>"/>
		<div class="control-group">
				<label class="control-label">Клиент / Email  </label>
				<div class="controls">
					<input type="text" name="client_name" value="<?php echo ucwords($invoice_details->client_name).' - '.$invoice_details->client_email; ?>" readonly class="form-control" id="client_name" />
				</div>
		</div>
		<br/>
		<div class="control-group">
			<label class="control-label">Номер счета </label>
			<div class="controls">
				<input type="text" name="invoice_number" id="invoice_number" value="<?php echo $invoice_details->invoice_number; ?>" readonly class="form-control" />
			</div>
		</div>
		<br/>
		<div class="control-group">
			<label class="control-label">Тема письма</label>
			<div class="controls">
				<input type="text" name="email_subject" id="email_subject" class="form-control" />
			</div>
		</div>

		<br/>
		<p>Счет будет приложен к письму. <a href="<?php echo site_url('invoices/viewpdf');?>/<?php echo $invoice_details->invoice_id; ?>">Посмотреть счет</a> </p>
	<a href="javascript: void(0);" onclick="javascript: ajax_send_email();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_send_email"><i class="fa fa-envelope"></i> Отправить письмо </a>
	</div>

	</form>
</div>
</div>
<hr/>
</div>
<div class="loading"></div>
</div>

