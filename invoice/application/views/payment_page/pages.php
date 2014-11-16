      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Payment Pages</h3>
			<a href="<?php echo site_url('payment_page/new_page'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create Payment Page </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of pages</h3>
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
                        <th>Page Name <i class="fa fa-sort"></i></th>
                        <th>Shop <i class="fa fa-sort"></i></th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
					<?php
					if( isset($pages) && $pages->num_rows() > 0 )
					{
						$counter = 1;
						foreach ($pages->result_array() as $count => $pages)
						{
						?>
						<tr>
						<td><?php echo $counter; ?></td>
                        <td><?php echo ucfirst($pages['page_name']); ?></td>
                        <td><?php echo ucfirst($pages['shop_name']); ?></td>
						<td>
						<a href="<?php echo site_url('payment_page/edit/'.$pages['page_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
						<a href="<?php echo site_url('payment_page/delete/'.$pages['page_id']);?>" onclick="return confirm('Are you sure you want to permanently delete this page?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
						</td>
						</tr>
						<?php
						$counter++;
						}
					}
					else
					{
					?>
					<tr class="no-cell-border"><td> There are no payment pages available at the moment.</td>
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