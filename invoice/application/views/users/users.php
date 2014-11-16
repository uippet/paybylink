      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Пользователи</h3>
			<a href="<?php echo $this->config->item('nav_base_url'); ?>users/createuser" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Создать пользователя </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Список пользователей, созданных вами</h3>
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
                        <th>Имя <i class="fa fa-sort"></i></th>
                        <th>Фамилия <i class="fa fa-sort"></i></th>
                        <th>Имя пользователя <i class="fa fa-sort"></i></th>
                        <th>Email <i class="fa fa-sort"></i></th>
						<th>Дата создания <i class="fa fa-sort"></i></th>
						<th>Действие</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
					<?php
					if( isset($users) && $users->num_rows() > 0 )
					{
						foreach ($users->result_array() as $count => $user)
						{
						?>
						<tr>
                        <td><?php echo ucfirst($user['first_name']); ?></td>
                        <td><?php echo ucfirst($user['last_name']); ?></td>
                        <td><?php echo $user['username']; ?></td>
						<td><?php echo $user['user_email']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($user['user_date_created'])); ?></td>
						<td>
						<a href="<?php echo $this->config->item('nav_base_url'); ?>users/edituser/<?php echo $user['user_id'];?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Изменить </i></a>
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border"><td> Пусто :(</td>
					<td></td>
					<td></td>
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