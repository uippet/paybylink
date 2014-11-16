 <div id="page-wrapper">
<div class="row">
  <div class="col-lg-12">
	<h3 class="pull-left">Изменить магазин</h3>
	<a href="<?php echo site_url('shops'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Shops </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> Изменение магазина</h3>
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
	<form role="form" method="POST" action="<?php echo site_url('shops/edit'); ?>/<?php echo (isset($shop->shop_id)) ? $shop->shop_id : ''?>" enctype="multipart/form-data">
	<input type="hidden" name="shop_id" value="<?php echo (isset($shop->shop_id)) ? $shop->shop_id : '';?>" />
	  <div class="form-group">
		<label>Название магазина</label>
		<input class="form-control" name="shop_name" value="<?php echo (isset($shop->shop_name)) ? $shop->shop_name : '';?>"/>
		<?php echo form_error('shop_name'); ?>
	  </div>
	  	   <div class="form-group">
		<label>Описание магазина</label>
		<input class="form-control" name="shop_description" value="<?php echo (isset($shop->shop_description)) ? $shop->shop_description : '';?>" />
		<?php echo form_error('shop_description'); ?>
	  </div>
	  <div class="form-group">
		<label>Контактный телефон магазина</label>
		<input class="form-control" name="shop_phone" value="<?php echo (isset($shop->shop_phone)) ? $shop->shop_phone : '';?>" />
		<?php echo form_error('shop_phone'); ?>
	  </div>
	  <div class="form-group">
		<label>email для оповещений об успешных транзанциях</label>
		<input class="form-control" name="shop_email" value="<?php echo (isset($shop->shop_email)) ? $shop->shop_email : '';?>" />
		<?php echo form_error('shop_email'); ?>
	  </div>
	   <div class="form-group">
		<label>Адрес магазина</label>
		<input class="form-control" name="shop_address" value="<?php echo (isset($shop->shop_address)) ? $shop->shop_address : '';?>"/>
		<?php echo form_error('shoppw'); ?>
	  </div>
	 <div class="form-group">
		<label>ShopID - получите от сотрудника Яндекс.Денег</label>
		<input class="form-control" name="payment_shop_id" value="<?php echo (isset($shop->payment_shop_id)) ? $shop->payment_shop_id : '';?>"/>
		<?php echo form_error('payment_shop_id'); ?>
	  </div>
	   
	  <div class="form-group">
		<label>SCID - получите от сотрудника Яндекс.Денег</label>
		<input class="form-control" name="scid" value="<?php echo (isset($shop->scid)) ? $shop->scid : '';?>"/>
		<?php echo form_error('scid'); ?>
	  </div>
	  <div class="form-group">
		<label>shoppassword</label>
		<input class="form-control" name="shoppw" value="<?php echo (isset($shop->shoppw)) ? $shop->shoppw : '';?>" maxlength="20"/>
		<?php echo form_error('shoppw'); ?>
	  </div>
	   
	   <div class="form-group">
			<label>Логотип</label><br/>
			<?php 
				$logo = ($shop->shop_logo != '') ? UPLOADSDIR.$shop->shop_logo : IMAGESFOLDER.'no-logo.jpg'; 
			?>
			<img src="<?php echo base_url().$logo;?>" width="200px" />
		 </div>
		<div class="form-group">
			<label for="logo">Выбрать логотип : </label>
				 <input type="file" class="filestyle" data-classButton="btn btn-primary" name="logo"/>
				 <br/><p class="has-error"><label class="control-label"><?php echo (isset($logoerror)) ? $logoerror : ''; ?></label></p>
		</div> <!-- /field -->
	   <div class="form-group">
	  <label>Доступные платежные опции по договору</label><br>
		<input type="checkbox" name="ymoney" value="1" <?php echo ($shop->ymoney) ? 'checked' : '' ;?> /> Яндекс.Деньги <br/>
		<input type="checkbox" name="credit_card" value="1" <?php echo ($shop->credit_card) ? 'checked' : '' ;?> /> Банковские карты <br/>
		<input type="checkbox" name="mobile_phone" value="1" <?php echo ($shop->mobile_phone) ? 'checked' : '' ;?> /> Мобильная коммерция <br/>
		<input type="checkbox" name="kiosks" value="1" <?php echo ($shop->kiosks) ? 'checked' : '' ;?> /> Терминалы оплаты <br/>
		<input type="checkbox" name="webmoney" value="1" <?php echo ($shop->webmoney) ? 'checked' : '' ;?> /> WebMoney <br/>
	  </div>

	  <button type="submit" class="btn btn-large btn-success" name="editshopbtn" value="Edit shop">Обновить</button>
	  <button type="reset" class="btn btn-large btn-danger">Очистить форму</button>  

	</form>
		  
		 </div>  
		 <div class="col-lg-6"> 
			<label>Техническая анкета для отправки менеджеру по подключению:</label>
					<?php echo '<a href="'.base_url().UPLOADSDIR.'http_3x_paybylink.doc'.'"/>Ссылка на скачивание</a>'; ?>
			</div>
		  
		 </div>
		</div>
	  </div>
	</div>
  </div>
</div><!-- /.row -->
</div><!-- /#page-wrapper -->