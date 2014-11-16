<script type="text/javascript">
    $(function()
    {
        // Display the create invoice modal
        $('#modal-payment-frm').modal('show');

        $('#make_payment').click(function()
        {
            name = $('#name').val(); 
            email = $('#email').val(); 
            if(name == '' || email == '')
            {
				alert('Name and email are required');
				return false;
            }
            else{
                if(!validateEmail(email)){
                	alert('Enter a valid email');
    				return false;
                }
                else{
                    $('#payment_frm').submit();
            	}}
           });
    });

    function validateEmail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }   
</script>

<div id="modal-payment-frm" class="modal">
	<form class="form-horizontal" name="payment_frm" method="POST" action="<?php echo site_url('pp/pay'); ?>" id="payment_frm">
	<div class="col-lg-12">
			<div class="modal-header">
				<a data-dismiss="modal" class="close">&times;</a>
				<h4>Данные плательщика</h4>
			</div>
			<div class="modal-body">
			
			<div class="form-group">
				<label>Payment method : </label>
				<?php echo $payment_method; ?>
			 </div>
			
			<input type="hidden" name="amount" value="<?php echo $payment_amount; ?>"/>
			<input type="hidden" name="ShopID" value="<?php echo $page->payment_shop_id; ?>"/>
			<input type="hidden" name="scid" value="<?php echo $page->scid; ?>"/>
			<input type="hidden" name="paymentType" value="<?php echo  $payment_method; ?>"/>
			
			<div class="form-group">
				<label>ФИО <span class="error">*</span></label>
				<input class="form-control" name="name" id="name" value="<?php echo set_value('name');?>"/>
				<?php echo form_error('name'); ?>
			 </div>
			 
			 <div class="form-group">
				<label>Email <span class="error">*</span></label>
				<input class="form-control" name="email" id="email" value="<?php echo set_value('email');?>"/>
				<?php echo form_error('email'); ?>
			 </div>
			 
			 <div class="form-group">
				<label>Комментарий к платежу</label>
				<input class="form-control" name="phone" value="<?php echo set_value('phone');?>"/>
				<?php echo form_error('phone'); ?>
			 </div>
			
			</div>
			<div class="modal-footer">
			<button class="btn btn-primary pull-right" id="make_payment" type="button"><i class="fa fa-check"></i>  Оплатить</button>
			<button class="btn btn-danger pull-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Отмена </button>
			</div>
			</div>
	</form>
</div>