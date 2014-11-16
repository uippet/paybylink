<div id="page-wrapper">

<div class="row">
  <div class="col-lg-12">
	<h4 class="pull-left">Edit Payment Page</h4>
	<a href="<?php echo site_url('payment_page'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to pages </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-user"></i> Edit payment page </h4>
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
	<form role="form" method="POST" action="<?php echo site_url('payment_page/edit/'. $page->page_id) ; ?>" enctype="multipart/form-data">
	 <input type="hidden" name="page_id" value="<?php echo $page->page_id;?>" />
	<div class="form-group">
		<label>Shop : </label><br/>
		<?php echo $page->shop_name; ?>
	  </div>
	
	  <div class="form-group">
		<label>Page Name</label>
		<input class="form-control" name="page_name" value="<?php echo $page->page_name; ?>"/>
		<?php echo form_error('page_name'); ?>
	  </div>

	  <div class="form-group">
		<label>Page Description</label>
		<textarea class="form-control"  name="page_description" id="page_description" rows="10"><?php echo $page->description; ?></textarea>
		<?php echo form_error('page_description'); ?>
	  </div>
	  
	  <div class="form-group">
		<label>Name of Goods</label>
		<input class="form-control" name="goods_name" value="<?php echo $page->goods_name; ?>"/>
		<?php echo form_error('goods_name'); ?>
	  </div>
	  
	  	<div class="form-group">
	  	<label>image</label><br/>
			<?php 
				$image = ($page->image != '') ? UPLOADSDIR.'payment_pages/'.$page->image : IMAGESFOLDER.'no-logo.jpg'; 
			?>
	  		<img src="<?php echo base_url().$image;?>" width="200px" /><br/>
			<label for="image">Browse Image : </label><br/>
				 <input type="file" class="filestyle" data-classButton="btn btn-primary" name="image"/>
				 <p class="has-error"><label class="control-label"><?php echo (isset($imageerror)) ? $imageerror : ''; ?></label></p>
		</div> <!-- /field -->
	  
	  <div class="form-group">
		<label>Sum</label>
		<input class="form-control" name="sum" value="<?php echo $page->sum; ?>"/>
		<input  name="change_sum" value="1" type="checkbox" <?php echo ($page->user_change_sum == 1) ? 'checked' : '' ; ?>/> User can change sum (for crowdfund)
		<?php echo form_error('sum'); ?>
	  </div>
	  
	  <div class="form-group">
		<label>Recurrent</label><br/>
		<input  name="recurrent" value="1" <?php echo ($page->recurrent == 1) ? 'checked' : '' ; ?> type="radio" checked/> Yes <br/>
		<input  name="recurrent" value="0" <?php echo ($page->recurrent == 0) ? 'checked' : '' ; ?> type="radio"/> No <br/>
		<?php echo form_error('recurrent'); ?>
	  </div>

	  <button type="submit" class="btn btn-large btn-success" name="createpagebtn" value="New page">Edit Page</button>
	  <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

	</form>
		 </div>
		 
		 <div class="col-lg-6">
		 <div class="form-group" style="overflow-wrap: break-word;">
			<label>Payment Page URL</label><br />
			<a href="<?php echo site_url('pp/index/'.$page->page_unique_id); ?>" target="_blank"><?php echo site_url('pp/index/'.$page->page_unique_id); ?></a>
			
		  </div>
		 </div>
		</div>
	  </div>
	</div>
  </div>
</div><!-- /.row -->


</div><!-- /#page-wrapper -->