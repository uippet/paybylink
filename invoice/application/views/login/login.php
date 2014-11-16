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
		$(function() { $('#email').focus(); });
	</script>
</head>
	<body>
		<div class="well span5 center login-box">
		<div class="login-header">
		<h2>Авторизация</h2>
			<?php
			echo '<img src="'.base_url().UPLOADSDIR.'logo.png'.'" width="50%" />';
			?>
			<div class="clearfix"></div>
		</div>
		<?php
				if($this->session->flashdata('error')){
				?>
				<div class="alert alert-dismissable alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Ошибка !</strong> <?php echo $this->session->flashdata('error');?>
				</div>
				<?php
				}
				if($this->session->flashdata('success')){
					?>
				<div class="alert alert-dismissable alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Успешно !</strong> <?php echo $this->session->flashdata('success');?>
				</div>
				<?php
				}
				?>
				
			<form class="form-horizontal" action="<?php echo base_url();?>index.php/login" method="post">
				<fieldset>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control input-small" placeholder="Username" name="username"/>
						
					</div>
					
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<input type="password" class="form-control input-small" placeholder="Password" name="password" id="password"/>
					</div>
					
					<p class="pull-right">
						<button type="submit" class="btn btn-success" name="loginbttn" value="Login">Войти</button>
					</p>
					<p class="pull-left">
						<a href="<?php echo site_url('login/register');?>" class="btn btn-large btn"><i class="fa fa-chevron"> Регистрация </i></a>
						<a href="<?php echo site_url('login/resetpassword');?>" class="btn btn-large btn"><i class="fa fa-chevron"> Восcтановление пароля </i></a>
					</p>
					<div style="clear: both"></div>					
				</fieldset>
			</form>
		</div>
	</body>
</html>