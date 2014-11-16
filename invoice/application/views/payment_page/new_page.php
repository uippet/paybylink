<div id="page-wrapper">

<div class="row">
  <div class="col-lg-12">
	<h3 class="pull-left">Create Payment Page</h3>
	<a href="<?php echo site_url('payment_page'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to pages </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> Create a Payment Page </h3>
	  </div>
	  <div class="panel-body">
		<div class="table-responsive">
   <div class="col-lg-6"> 
		<?php
		if($this->session->flashdata('success')){
		?>
		<div class="alert alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
		</div>
		<?php
		}
		?>
	<form role="form" method="POST" action="<?php echo site_url('payment_page/new_page'); ?>" enctype="multipart/form-data">
	  <div class="form-group">
		<label>Shops</label>
		<select name="shop_id" id="shop_id" class="form-control"><?php echo $shops; ?></select>
		<?php echo form_error('shop_id'); ?>
	  </div>
	
	  <div class="form-group">
		<label>Page Name</label>
		<input class="form-control" name="page_name" value="<?php echo set_value('page_name');?>"/>
		<?php echo form_error('page_name'); ?>
	  </div>

	  <div class="form-group">
		<label>Page Description</label>
		<textarea class="form-control"  name="page_description" id="page_description" rows="10"><?php echo set_value('page_description');?></textarea>
		<?php echo form_error('page_description'); ?>
	  </div>
	  
	  <div class="form-group">
		<label>Name of Goods</label>
		<input class="form-control" name="goods_name" value="<?php echo set_value('goods_name');?>"/>
		<?php echo form_error('goods_name'); ?>
	  </div>
	  
	  	<div class="form-group">
			<label for="image">Browse Image : </label>
				 <input type="file" class="filestyle" data-classButton="btn btn-primary" name="image"/>
				 <p class="has-error"><label class="control-label"><?php echo (isset($imageerror)) ? $imageerror : ''; ?></label></p>
		</div> <!-- /field -->
	  
	  <div class="form-group">
		<label>Sum</label>
		<input class="form-control" name="sum" value="<?php echo set_value('sum');?>"/>
		<input  name="change_sum" value="1" type="checkbox" checked/> User can change sum (for crowdfund)
		<?php echo form_error('sum'); ?>
	  </div>
	  
	  <!-- <div class="form-group">
		<label>Recurrent</label><br/>
		<input  name="recurrent" value="1" type="radio" checked/> Yes <br/>
		<input  name="recurrent" value="0" type="radio"/> No <br/>
		<?php echo form_error('recurrent'); ?>
	  </div> -->

	  <button type="submit" class="btn btn-large btn-success" name="createpagebtn" value="New page">Create Page</button>
	  <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

	</form>
		 </div>
		</div>
	  </div>
	</div>
  </div>
</div><!-- /.row -->


</div><!-- /#page-wrapper -->