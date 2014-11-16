      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">API</h3>
            <?php if($this->session->userdata('level') == 1) : ?>
			<a href="<?php echo site_url('api/create'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create API </i></a>
         	<?php endif; ?>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of API</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
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
                  <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                      <tr class="table_header">
                      	<th></th>
                        <th>Where Used <i class="fa fa-sort"></i></th>
                        <th>Shop <i class="fa fa-sort"></i></th>
						<?php if($this->session->userdata('level') == 1) : ?>
						<th>Actions</th>
						<?php endif; ?>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if( isset($apis) && $apis->num_rows() > 0 )
					{
						$counter = 1;
						foreach ($apis->result_array() as $count => $api)
						{
						?>
						<tr>
						<td><?php echo $counter; ?></td>
                        <td><?php echo ucwords($api['where_used']); ?></td>
                        <td><?php echo $api['shop_name']; ?></td>
						<?php if($this->session->userdata('level') == 1) : ?>
						<td>
						<a href="<?php echo site_url('api/edit/'.$api['api_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
						<a href="<?php echo site_url('api/delete/'.$api['api_id']);?>" onclick="return confirm('Are you sure you want to permanently delete this API?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
						</td>
						<?php endif; ?>
						</tr>
						<?php
						$counter++;
						}
					}
					else
					{
					?>
					<tr class="no-cell-border"><td> There are no apis available at the moment.</td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<?php
					}
					?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->