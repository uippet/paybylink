<script type="text/javascript">
    $(function()
    {
        // Display the create invoice modal
        $('#modal-enter-payment').modal('show');
		$('.date').datepicker( {autoclose: true, format: 'dd-mm-yyyy'} );
		$(".date").datepicker("setDate", new Date());
		
		$('#btn_add_payment').click(function()
        {
            $.post("<?php echo site_url('invoices/addpayment'); ?>", {
                invoice_id: $('#invoice_id').val(),
                payment_amount: $('#payment_amount').val(),
                payment_date: $('#payment_date').val(),
                payment_note: $('#payment_note').val()
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success == '1')
                {
                    // The validation was successful and payment was added
                    window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
                }
                else
                {
                    // The validation was not successful
                    $('.control-group').removeClass('has-error');
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().parent().addClass('has-error');

                    }
                }
            });
        });
	});
</script>
<?php 
$config = get_business_config();
$this->config->currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' $ ';
?>
<div id="modal-enter-payment" class="modal" style="width:400px">
	<div class="modal-header">
		<a data-dismiss="modal" class="close">&times;</a>
		<label class="control-label">Номер счета : <?php echo $invoice->invoice_number; ?> </label>
	</div>
	<div class="modal-body">
	
	<div class="col-lg-12">
		<form class="form-horizontal" method="POST" action="<?php echo site_url('invoices/addpayment');?>">
			<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice->invoice_id; ?>">
			<div class="control-group error">
				<label class="control-label">Сумма: </label>
				<div class="controls">
					<input type="text" name="payment_amount" class="form-control" id="payment_amount" value="">
				</div>
			</div>
			<label class="control-label">Дата платежа: </label>
			<div class="form-group input-group date" style="margin-left:0;">
               <input size="16" type="text" name="payment_date" class="form-control" id="payment_date" readonly />
                <span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
            </div>
			<div class="control-group">
				<label class="control-label">Примечание: </label>
				<div class="controls">
					<textarea name="payment_note" class="form-control" id="payment_note"></textarea>
				</div>

			</div>
		</form>
	
	<div style="clear:both"></div>
	<div class="modal-footer">
		<button class="btn btn-primary" id="btn_add_payment" type="button"><i class="fa fa-check"></i> Добавить платеж</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Отмена</button>
	</div>
	</div>
	</div>
</div>