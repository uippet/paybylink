      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Добавить клиента</h3>
			<a href="<?php echo $this->config->item('nav_base_url'); ?>clients" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Вернуться к списку клиентов </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Добавить нового клиента </h3>
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
			<form role="form" method="POST" action="<?php echo $this->config->item('nav_base_url'); ?>clients/createclient">
              <div class="form-group">
                <label>ФИО клиента</label>
                <input class="form-control" name="client_name" value="<?php echo set_value('client_name');?>"/>
				<?php echo form_error('client_name'); ?>
              </div>
			  
			   <div class="form-group">
                <label>Email клиента</label>
                <input class="form-control" name="client_email" value="<?php echo set_value('client_email');?>"/>
				<?php echo form_error('client_email'); ?>
              </div>
              
              <div class="form-group">
                <label>Адрес клиента</label>
                <input class="form-control" name="client_address" value="<?php echo set_value('client_address');?>"/>
				<?php echo form_error('client_address'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Город, страна</label>
                <input class="form-control" name="client_city" value="<?php echo set_value('client_city');?>"/>
				<?php echo form_error('client_city'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Телефон клиента</label>
                <input class="form-control" name="client_telephone" value="<?php echo set_value('client_telephone');?>"/>
				<?php echo form_error('client_telephone'); ?>
              </div>
			  
			   <div class="form-group">
                <label>Комментарий</label>
                <input class="form-control" name="client_fax" value="<?php echo set_value('client_fax');?>"/>
				<?php echo form_error('client_fax'); ?>
              </div>
			  
			  

              <button type="submit" class="btn btn-large btn-success" name="createclientbtn" value="New Client">Добавить клиента</button>
              <button type="reset" class="btn btn-large btn-danger">Очистить форму</button>  

            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->