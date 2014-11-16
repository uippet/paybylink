<div id="page-wrapper">
<div class="row">
  <div class="col-lg-12">
	<h3 class="pull-left">Добавить магазин</h3>
	<a href="<?php echo site_url('shops'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Назад к магазинам </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> Добавить магазин</h3>
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
		<?php
		if($this->session->flashdata('error')){
		?>
		<div class="alert alert-dismissable alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Ошибка !</strong> <?php echo $this->session->flashdata('error');?>
		</div>
		<?php
		}
		?>
	<form role="form" method="POST" action="<?php echo site_url('shops/create'); ?>" enctype="multipart/form-data">
	  <div class="form-group">
		<label>Название магазина</label>
		<input class="form-control" name="shop_name" value="<?php echo set_value('shop_name');?>"/>
		<?php echo form_error('shop_name'); ?>
	  </div>
	  <div class="form-group">
		<label>Описание магазина</label>
		<input class="form-control" name="shop_description" value="<?php echo set_value('shop_description');?>" />
		<?php echo form_error('shop_description'); ?>
	  	</div>
	  	<div class="form-group">
		<label>Контактный телефон магазина</label>
		<input class="form-control" name="shop_phone" value="<?php echo set_value('shop_phone');?>" />
		<?php echo form_error('shop_phone'); ?>
	  	</div>
		  <div class="form-group">
			<label>email для оповещений об успешных транзанциях</label>
			<input class="form-control" name="shop_email" value="<?php echo (isset($shop->shop_email)) ? $shop->shop_email : '';?>" />
			<?php echo form_error('shop_email'); ?>
		  </div>
	  	<div class="form-group">
		<label>Адрес магазина</label>
		<input class="form-control" name="shop_address" value="<?php echo set_value('shop_address');?>" />
		<?php echo form_error('shop_address'); ?>
	  	</div>
	    <div class="form-group">
		<label>shopid - получите от сотрудника Яндекс.Денег</label>
		<input class="form-control" name="payment_shop_id" value="<?php echo set_value('payment_shop_id');?>"/>
		<?php echo form_error('payment_shop_id'); ?>
	  </div>
	  <div class="form-group">
		<label>scid - получите от сотрудника Яндекс.Денег</label>
		<input class="form-control" name="scid" value="<?php echo set_value('scid');?>"/>
		<?php echo form_error('scid'); ?>
	  </div>
	    <div class="form-group">
		<label>shoppassword</label>
		<input class="form-control" name="shoppw" value="<?php echo set_value('shoppw');?>" maxlength="20"/>
		<?php echo form_error('shoppw'); ?>
	  	</div>
	  	<div class="form-group">
			<label for="logo">Выберите логотип : </label>
				 <input type="file" class="filestyle" data-classButton="btn btn-primary" name="logo"/>
				 <br/><p class="has-error"><label class="control-label"><?php echo (isset($logoerror)) ? $logoerror : ''; ?></label></p>
		</div> <!-- /field -->
	  <div class="form-group">
	  <label>Доступные платежные опции по договору</label><br>
		<input type="checkbox" name="ymoney" value="1" /> Яндекс.Деньги <br/>
		<input type="checkbox" name="credit_card" value="1" /> Банковские карты <br/>
		<input type="checkbox" name="mobile_phone" value="1" /> Мобильная коммерция <br/>
		<input type="checkbox" name="kiosks" value="1" /> Оплата наличными через терминалы <br/>
		<input type="checkbox" name="webmoney" value="1" /> WebMoney <br/>
	  </div>

	 <button type="submit" class="btn btn-large btn-success" name="createshopbtn" value="New Shop">Сохранить магазин</button>
	  <button type="reset" class="btn btn-large btn-danger">Очистить форму</button>  

	</form>
		  
		 </div>  
		 <div class="col-lg-6"> 
		 <div class="form-group">
			</div>
		  
		 </div>
		 
		</div>
	  </div>
	</div>
  </div>
</div><!-- /.row -->


</div><!-- /#page-wrapper -->