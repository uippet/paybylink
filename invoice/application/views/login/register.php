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
	<link rel="stylesheet" href="<?php echo base_url().FONTSFOLDER;?>css/font-awesome.min.css">
	<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>jquery.min.js"></script>
	<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>bootstrap.js"></script>
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
		$(function() { $('#username').focus(); });
	</script>
</head>
	<body>
		<div class="well span5 center login-box" style="text-align:left">
		<p><a style="float: left" href="<?php echo site_url('login');?>" class="btn btn-large btn-info">  Назад к авторизации </a></p><br/><br/>
		<div style="clear:both"></div>
				<?php
				if($this->session->flashdata('success')){
				?>
				<div class="alert alert-dismissable alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Успешно !</strong> <?php echo $this->session->flashdata('success');?>
				</div>
				<?php
				}
				?>
			<form role="form" method="POST" action="<?php echo site_url('login/register'); ?>">
              <div class="form-group">
                <label>Имя</label>
                <input class="form-control" name="firstname" value="<?php echo set_value('firstname');?>"/>
				<?php echo form_error('firstname'); ?>
              </div>

              <div class="form-group">
                <label>Фамилия</label>
                <input class="form-control" name="lastname" value="<?php echo set_value('lastname');?>"/>
				<?php echo form_error('lastname'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" value="<?php echo set_value('email');?>"/>
				<?php echo form_error('email'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Номер телефона</label>
                <input class="form-control" name="phone" value="<?php echo set_value('phone');?>"/>
				<?php echo form_error('phone'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Имя пользователя</label>
                <input class="form-control" name="username" value="<?php echo set_value('username');?>"/>
				<?php echo form_error('username'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Пароль</label>
                <input class="form-control" name="password" type="password" value="<?php echo set_value('password');?>"/>
				<?php echo form_error('password'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Повторите ввод пароля</label>
                <input class="form-control" name="confirmpassword" type="password" value="<?php echo set_value('confirmpassword');?>"/>
				<?php echo form_error('confirmpassword'); ?>
              </div>
				<button type="reset" class="btn btn-large btn-danger" >Очистить форму</button>  
              <button type="submit" class="btn btn-large btn-success" style="float:right" name="registerbtn" value="New User">Зарегистрироваться</button>
              

            </form>
		</div>
	</body>
</html>