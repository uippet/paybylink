  <div id="page-wrapper">

	<div class="row">
	  <div class="col-lg-12">
		<h3 class="pull-left">Продукты</h3>
		<?php if($this->session->userdata('level') == 1) : ?>
		<a href="<?php echo $this->config->item('nav_base_url'); ?>products/createproduct" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Добавить продукт </i></a>
	  	<?php endif; ?>
	  </div>
	</div><!-- /.row -->

	<div class="row">
	  <div class="col-lg-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-user"></i> Шаблоны заказов</h3>
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
					<th>Название товара или услуги <i class="fa fa-sort"></i></th>
					<th>Описание <i class="fa fa-sort"></i></th>
					<th>Стоимость за штуку <i class="fa fa-sort"></i></th>
				  </tr>
				</thead>
				<tbody>
				<?php
				if( isset($products) && $products->num_rows() > 0 )
				{
					foreach ($products->result_array() as $count => $product)
					{
					?>
					<tr>
					<td><?php echo ucfirst($product['product_name']); ?></td>
					<td><?php echo limit_text($product['product_description'], 50); ?></td>
					<td><?php echo $product['product_unitprice']; ?></td>
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