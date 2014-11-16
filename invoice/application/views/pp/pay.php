<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PayByLink.RU</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<link href="<?php echo base_url().CSSFOLDER; ?>bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url().CSSFOLDER; ?>login.css" rel="stylesheet">
	<link href="<?php echo base_url().CSSFOLDER; ?>style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url().FONTSFOLDER;?>css/font-awesome.min.css">
	<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>jquery.min.js"></script>
	<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>bootstrap.js"></script>
	<script type="text/javascript">
	$(function() {
	$('.bttn_payment_form').click(function() {
		payment_type = $(this).attr('id');
		amount = $('#sum').val();
		$('#modal-placeholder').load("<?php echo site_url('pp/payment_form/'.$page->page_id); ?>/" + payment_type + '/' + amount  + '/' + Math.floor(Math.random()*1000));
	});
	});

	</script>
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
		$(function() { $('#username').focus(); });
	</script>
</head>
	<body>
	<div id="modal-placeholder"></div>
		<div class="well col-lg-12 login-box center " style="text-align:left; width:800px; margin-top: 20px; border-collapse:collapse;background-color:#F8F8F8;background-image: url(<?=base_url();?>assets/img/email_template/bg_texture.png);">
				<?php
				if($this->session->flashdata('success')){
				?>
				<div class="alert alert-dismissable alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
				</div>
				<?php 
				}
				if(empty($page)) : ?>
				<div class="alert alert-dismissable alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error !</strong> Wrong url used, please use a valid url
				</div>
				
				<?php else : ?>
				<div class="col-lg-12" style="text-align: center"><h2><?php echo ucfirst($page->page_name); ?></h2></div>
				<hr/>
				<div class="row">
					<div class="col-lg-6">
					<div class="form-group" style="height: auto; word-wrap: break-word;">
					<?php echo ucfirst($page->description); ?>
					</div></div>
					<div class="col-lg-6">
					<?php $image = ($page->image != '') ? UPLOADSDIR.'payment_pages/'.$page->image : IMAGESFOLDER.'no-logo.jpg'; ?>
	  				<img src="<?php echo base_url().$image;?>" width="200px" /></div>
				</div>
				
				<div class="row">
					<div class="col-lg-6">
					 <div class="form-group">
		                <br/><b><?php echo $page->goods_name;?></b>
		              </div>
					</div>
					<div class="col-lg-6">
					 <div class="form-group">
		                <br/>
		                <?php if($page->user_change_sum) : echo $page->currency; ?>
		                <input type="text" name="sum" id="sum" value="<?php echo $page->sum; ?>" />
		                <?php  else : echo $page->currency; ?>
		                <input type="text" name="sum" id="sum" value="<?php echo $page->sum; ?>" readonly/>
		                <?php endif;
		                ?>
		                
		                <?php if($page->recurrent) : ?>
		               <br/><input type="checkbox" checked name="recurrent" checked />Перечислять ежемесячно
		              <?php endif; ?>
		                
		              </div>
		              
					</div>
					<div style="clear:both"></div>
					<div class="col-lg-12">
					<?php if($page->credit_card) : ?>	
					<p style="text-align: center;margin-top:20px">
						<a href="javascript: void(0);" class="bttn_payment_form" id="AC" title="Оплата банков�?кой картой"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/cards.png"></a>
					</p>
					<?php endif; ?>
					<?php if($page->ymoney) : ?>	
					<p style="text-align: center;margin-top:20px">
						<a href="javascript: void(0);" class="bttn_payment_form" title="Оплата Яндек�?.Деньгами" id="PC" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/yamoney.png"></a>
					</p>
					<?php endif; ?>
					<?php if($page->mobile_phone) : ?>
					<p style="text-align: center;margin-top:20px">
						<a href="javascript: void(0);" class="bttn_payment_form" title="Оплата �?о �?чета мобильного телефона"  id="MC" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/mobile.png"></a>
					</p>
					<?php endif; ?>
					<?php if($page->kiosks) : ?>
					<p style="text-align: center;margin-top:20px">
						<a href="javascript: void(0);" class="bttn_payment_form" title="Оплата наличными" id="GP" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/cash.png"></a>
					</p>
					<?php endif; ?>
					<?php if($page->webmoney) : ?>
					<p style="text-align: center;margin-top:20px;margin-bottom:30px">
						<a href="javascript: void(0);" class="bttn_payment_form" title="Оплата �?о �?чета Webmoney" id="WM" target="_blank"><img width="299" height="50" alt="" src="<?=base_url();?>assets/img/email_template/webmoney.png"></a>
					</p>
					<?php endif; ?>
					</div>
					
				</div>
				
				<?php endif; ?>
				
		</div>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-52109863-1', 'paybylink.ru');
		  ga('send', 'pageview');

		</script>
	</body>
</html>