 <script type="text/javascript">
	    $(function() {
			$('input:radio[name="invoice_status"]').change(function(){
			$('.loading').fadeIn('slow');
			var status = $(this).val();
			$.post("<?php echo site_url('invoices/ajax_filter_invoices'); ?>", {
                status: status,
            },
            function(data) {
               $('#invoice_table_body').html(data);
			   $('.loading').fadeOut('slow');
            });
				
			});
			
		});
</script>
<div class="loading"></div>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Счета</h3>
			<a href="<?php echo site_url('invoices/newinvoice'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Выставить новый счет </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Список счетов</h3>
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
				<div class="well" style="background-color: #ccc;">
					<div class="form-group" style="margin-bottom:0px">
					<label> Фильтр : </label> &nbsp;&nbsp;
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'all') ? 'checked' : ''; ?> id="allinvoices" value="all"> Все счета</label>
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'paid') ? 'checked' : ''; ?> id="paidinvoices" value="paid"> Оплаченые</label>
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'unpaid') ? 'checked' : ''; ?> id="unpaidinvoices" value="unpaid"> Неоплаченые</label>
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'cancelled') ? 'checked' : ''; ?> id="cancelledinvoices" value="cancelled"> Анулированные</label>
					</div>
				</div>
                  <table class="table table-bordered table-striped tablesorter">
                    <thead>
                      <tr class="table_header">
						<th>Статус</th>
                        <th>Номер счета.</i></th>
						<th>Клиент</th>
                        <th class="text-right">Сумма счета, <?php echo $this->config->currency_symbol ?></th>
						<th>Действие</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
					<?php
					if( isset($invoices) && !empty($invoices))
					{
						foreach ($invoices as $count => $invoice)
						{
						?>
						<tr>
						<td>
						<?php 
						if($invoice['invoice_status'] == 'PAID'){ $class='success'; } 
						if($invoice['invoice_status'] == 'UNPAID'){ $class='warning'; } 
						if($invoice['invoice_status'] == 'CANCELLED'){ $class='danger'; } 
						?>
						<span class="label label-<?php echo $class;?>"><?php echo $invoice['invoice_status'];?></span>
						</td>
                        <td><a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>"><?php echo $invoice['invoice_number']; ?></a></td>
                        <td><a href="<?php echo site_url('clients/editclient/'.$invoice['client_id']); ?>"><?php echo ucwords($invoice['client_name']); ?></a></td>
                        <td class="text-right"><?php 
						echo $this->config->currency_symbol.number_format($invoice['invoice_amount'], 2); ?></td>
						<td style="width:32%">
						<a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>" class="btn btn-xs btn-primary"><i class="fa fa-check"> Изменить </i></a>
						<a href="javascript:;" class="btn btn-info btn-xs" onclick="viewInvoice('<?php echo $invoice['invoice_id']; ?>')"><i class="fa fa-search"> Предпросмотр </i></a>
						<a href="<?php echo site_url('invoices/viewpdf');?>/<?php echo $invoice['invoice_id']; ?>" class="btn btn-warning btn-xs"> PDF </a>
						<!-- <a href="#" class="btn btn-xs btn-primary"><i class="fa fa-arrow-right"> Refund </i></a> -->
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border">
					<td> Пусто :(</td>
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