<link href="<?php echo base_url().CSSFOLDER; ?>bootstrap.css" rel="stylesheet">
<!-- Add custom CSS here -->
<link href="<?php echo base_url().CSSFOLDER; ?>style.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url().FONTSFOLDER;?>css/font-awesome.min.css">
<div id="page-wrapper">
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-user"></i> Make Payment </h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">		 
		 <div class="col-lg-12">
		 <?php
		 if(!empty($api)) : ?>
		 		<div class="alert alert-dismissable alert-danger">
				<strong>Error !</strong> API does not exist!
				</div>
		 <?php
		 	else : 
		 ?>
		<form>
		  <div class="form-group">
            <label>Sum</label><br />
            <input type="text" name="sum" id="sum" class="form-control" /> 
			<?php echo form_error('sum'); ?>
          </div>
          <div class="form-group">
            <label>Email</label><br />
            <input type="text" name="email" id="email" class="form-control" /> 
			       <?php echo form_error('email'); ?>
          </div>    
           <div class="form-group">
            <p style="margin-top:20px">
              <a href="javascript:void(0)" class="payment_options" id="AC" title="Банковской картой"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/cards.png"></a>
            </p>
            <p style="margin-top:20px">
              <a href="javascript:void(0)" class="payment_options" id="PC" title="С помощью Яндекс.Денег"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/yamoney.png"></a>
            </p>
            <p style="margin-top:20px">
              <a href="javascript:void(0)" class="payment_options" id="MC" title="С мобильного телефона"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/mobile.png"></a>
            </p>
            <p style="margin-top:20px">
              <a href="javascript:void(0)" class="payment_options" id="GP" title="Наличными через терминал"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/cash.png"></a>
            </p>
            <p style="margin-top:20px;margin-bottom:30px">
              <a href="javascript:void(0)" class="payment_options" id="WM" title="С помощью Webmoney"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/webmoney.png"></a>
            </p>
          </div> 
        </form>
          <?php endif; ?>
		 </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- /.row -->
</div><!-- /#page-wrapper -->
<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>jquery.min.js"></script>
<script type="text/javascript">
$(function() {
  $('.payment_options').click(function() {
      var option = $(this).attr('id');
      var email  = $('#email').val();
      var sum    = $('#sum').val();

    $.post("<?php echo site_url('apifrm/pay'); ?>", {'option': option, 'email' : email, 'sum' : sum
  },
  function(data) {
    var response = JSON.parse(data);
    if (response.success == '1') 
    {

    }
    else {
    }
  });
  });

});

</script>