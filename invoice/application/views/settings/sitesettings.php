<?php
	if(isset($settings) && !empty($settings))
	{
		$config = array();
		$config['name'] 	=	$settings->business_name;
		$config['address'] 	=	$settings->address;
		$config['fax'] 		=	$settings->fax;
		$config['email'] 	=	$settings->email;
		$config['phone'] 	=	$settings->phone;
		$config['currency'] =	$settings->currency;
		$config['logo'] 	=	$settings->logo;
		$config['website'] 	=	$settings->website;
		$config['business_id'] =	$settings->business_id;
	}
?>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Ваша организация </h3>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-gear"></i>Ваша организация </h3>
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
			<form role="form" method="POST" action="<?php echo $this->config->item('nav_base_url'); ?>settings">
			<input type="hidden" value="<?php echo (isset($config['business_id'])) ? $config['business_id'] : ''; ?>" name="business_id" id="business_id" />
              <div class="form-group">
                <label>Название компании/организации</label>
                <input class="form-control" name="companyname" value="<?php echo (isset($config['name'])) ? $config['name'] : ''; ?>"/>
				<?php echo form_error('companyname'); ?>
              </div>

              <div class="form-group">
                <label>Адрес компании</label>
                <input class="form-control" name="companyaddress" value="<?php echo (isset($config['address'])) ? $config['address'] : ''; ?>"/>
				<?php echo form_error('companyaddress'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Факс или дополнительный номер телефона </label>
                <input class="form-control" name="companyfax" value="<?php echo (isset($config['fax'])) ? $config['fax'] : ''; ?>"/>
				<?php echo form_error('companyfax'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Email компании</label>
                <input class="form-control" name="companyemail" value="<?php echo (isset($config['email'])) ? $config['email'] : ''; ?>"/>
				<?php echo form_error('companyemail'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Номер телефона компании</label>
                <input class="form-control" name="companyphone" value="<?php echo (isset($config['phone'])) ? $config['phone'] : ''; ?>"/>
				<?php echo form_error('companyphone'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Сайт компании</label>
                <input class="form-control" name="companywebsite" value="<?php echo (isset($config['website'])) ? $config['website'] : ''; ?>"/>
				<?php echo form_error('companywebsite'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Символ валюты</label>
                <input class="form-control" name="currency" value="<?php echo (isset($config['currency'])) ? $config['currency'] : ''; ?>"/>
				<?php echo form_error('currency'); ?>
              </div>
			  
              <button type="submit" class="btn btn-large btn-success" name="updatesettingsbtn" value="save settings">Save Configurations</button>
            </form>
		</div>
			<!-- company logo area -->
				<div class="col-lg-6"> 
					<div class="panel panel-primary center">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if(isset($logoerror)){
								?>
									<div class="alert alert-dismissable alert-danger">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Ошибка !</strong> <?php echo $logoerror;?>
									</div>
								<?php
								}
								?>
								<?php
								if($this->session->flashdata('logosuccess')){
								?>
									<div class="alert alert-dismissable alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Успешно !</strong> <?php echo $this->session->flashdata('logosuccess');?>
									</div>
								<?php
								}
								?>
								<div class="form-group">
									<label>Логотип компании</label><br/>
									<?php 
										$logo = (isset($config['logo']) && !empty($config['logo'])) ? UPLOADSDIR.$config['logo'] : IMAGESFOLDER.'no-logo.jpg'; 
									?>
									<img src="<?php echo base_url().$logo;?>" width="200px" />
								 </div>
								 <form method="POST" action="" enctype="multipart/form-data" >
								 <input type="hidden" value="<?php echo (isset($config['business_id'])) ? $config['business_id'] : ''; ?>" name="business_id" id="business_id" />
								 <div class="form-group">
									<label for="logo">Выберите логотип : </label>
										 <input type="file" class="filestyle" data-classButton="btn btn-primary" name="logo"/>
										 <br/><?php echo form_error('logo'); ?>
								</div> <!-- /field -->
								<button type="submit" class="btn btn-large btn-success" name="updatelogobtn" value="New Logo">Обновить логотип</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			  
            </div>
          </div>
		 </div>
        </div><!-- /.row -->
 </div><!-- /#page-wrapper -->