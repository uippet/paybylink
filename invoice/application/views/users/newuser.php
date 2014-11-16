      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Добавить пользователя</h3>
			<a href="<?php echo $this->config->item('nav_base_url'); ?>users" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Назад к списку пользователей</i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Создать новый аккаунт </h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
           <div class="col-lg-6"> 
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
			<form role="form" method="POST" action="<?php echo $this->config->item('nav_base_url'); ?>users/createuser">
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
                <label>К какому магазину привязать пользователя?</label>
                <select class="form-control" name="shop" id="shop">
                <?php echo $shops; ?>
                </select>
				<?php echo form_error('shop'); ?>
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
                <label>Повторите пароль</label>
                <input class="form-control" name="confirmpassword" type="password" value="<?php echo set_value('confirmpassword');?>"/>
				<?php echo form_error('confirmpassword'); ?>
              </div>

              <button type="submit" class="btn btn-large btn-success" name="createuserbtn" value="New User">Создать пользователя</button>
              <button type="reset" class="btn btn-large btn-danger">Очистить форму</button>  

            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->