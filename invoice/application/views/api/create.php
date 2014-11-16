      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Create API</h3>
			<a href="<?php echo site_url('api'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to API List </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Create a new API </h3>
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
			<form role="form" method="POST" action="<?php echo site_url('api/create'); ?>">
			  <div class="form-group">
                <label>Shop</label>
                <select name="shop" id="shop" class="form-control"><?php echo $shops; ?></select>
				<?php echo form_error('shop'); ?>
              </div>
              <div class="form-group">
                <label>API Name</label>
                <input class="form-control" name="api_name" value="<?php echo set_value('api_name');?>"/>
				<?php echo form_error('api_name'); ?>
              </div>
			  
			   <div class="form-group">
                <label>Where you will use the API</label>
                <input class="form-control" name="where_used" value="<?php echo set_value('where_used');?>"/>
				<?php echo form_error('where_used'); ?>
              </div>
              
              <div class="form-group">
                <label>API Type</label><br />
                <input type="radio" name="api_type" class="api_type" value="email" checked/> Email <br />
                <input type="radio" name="api_type" class="api_type" value="iframe"/> Iframe <br />
				<?php echo form_error('api_type'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Recurrent</label><br />
                <input type="radio" name="recurrent"  class="recurrent" value="1" checked/> Yes  <span  id="recurrent_days">Every <input type="text" name="recurrent_days" /> Days</span> <br />
                <input type="radio" name="recurrent" class="recurrent" value="0"/> No <br />
				<?php echo form_error('recurrent'); ?>
              </div> 
				 </div> 
				 
				 <div class="col-lg-6">
				  <div class="form-group">
	                <label>API Key</label><br />
	                <input type="text" name="api_key" class="form-control" /> 
					<?php echo form_error('api_key'); ?>
	              </div>
	              
	              <div class="form-group">
	                <label>API Example</label>
	                <div id="email_example">
	                <h5>Email</h5>
	                <textarea name="email_type" cols="30" rows="10" class="form-control" >This is the email example</textarea>
	                </div>
	                <div style="display:none" id="iframe_example">
	                <h5>Iframe</h5>
	                <textarea name="iframe_type" cols="30" rows="10" class="form-control" >This is the iframe example</textarea>
	                </div>
	              </div>
	              
	               <button type="submit" class="btn btn-large btn-success" name="createapibtn" value="New api">Create API</button>
	              <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  
	
	            </form>
	              
				 </div>
				  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- /#page-wrapper -->
      <script>
		$(function(){
			$('input[name=recurrent]').change(function(){
				selected =  this.value;  
				if(selected == 1){ $('#recurrent_days').show(); }else  { $('#recurrent_days').hide(); }
			});
			
			$('input[name=api_type]').change(function(){
				selected =  this.value;  
				if(selected == 'email'){
					 $('#email_example').show(); 
					 $('#iframe_example').hide();
					 
				} else  { 
					$('#email_example').hide(); 
					$('#iframe_example').show();
				}
			});
		});


      </script>