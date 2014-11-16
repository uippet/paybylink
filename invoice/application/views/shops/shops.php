      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Магазины</h3>
			<a href="<?php echo site_url('shops/create'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Добавить магазин </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Список ваших магазинов</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
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
                  <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                      <tr class="table_header">
                        <th></th>
                        <th>Название магазина<i class="fa fa-sort"></i></th>
						<th>Действие</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$counter = 1;
					if( isset($shops) && $shops->num_rows() > 0 )
					{
						foreach ($shops->result_array() as $count => $shop)
						{
						?>
						<tr>
                        <td><?php echo $counter++; ?>.</td>
                        <td><?php echo $shop['shop_name']; ?></td>
						<td>
						<a href="<?php echo site_url('shops/edit/'.$shop['shop_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Изменить </i></a>
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border">
					<td> There are no Shops available at the moment.</td>
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