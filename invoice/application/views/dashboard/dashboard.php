      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h2>Дашборд</h2>
   
          </div>
        </div><!-- /.row -->
		
		<div class="row">
		<div class="col-lg-12">
		</div>
		</div>
		
		<div class="row">
		<div class="col-lg-12">
		<hr/>
		</div>
		</div>
		
		
        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-usd fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['all_invoices']; ?></p>
                    <p class="announcement-text">Выставлено счетов</p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['all_invoices'] > 0){ ?>
              <a href="<?php echo site_url('invoices');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-7">
                      Показать все счета
                    </div>
                    <div class="col-xs-5 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-money fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['unpaid_invoices']; ?></p>
                    <p class="announcement-text">Неоплаченные счета</p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['unpaid_invoices'] > 0){ ?>
              <a href="<?php echo site_url('invoices/index/unpaid');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-9">
                      Показать все неоплаченные счета
                    </div>
                    <div class="col-xs-3 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['paid_invoices']; ?></p>
                    <p class="announcement-text">Оплаченные счета</p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['paid_invoices'] > 0){?>
              <a href="<?php echo site_url('invoices/index/paid');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      Показать все оплаченные счета
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
		   <div class="col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-times fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['cancelled_invoices']; ?></p>
                    <p class="announcement-text">Аннулированные счета </p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['cancelled_invoices'] > 0){ ?>
              <a href="<?php echo site_url('invoices/index/cancelled');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      Показать аннулированные счета
                    </div>
                    <div class="col-xs-2 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money"></i> Последние счета</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                   <table class="table table-bordered table-striped">
                    <thead>
                      <tr class="table_header">
						<th>Статус</th>
                        <th>Номер счета</i></th>
						<th>Плательщик</th>
                        <th class="text-right">Сумма </th>
						<th class="text-right">Оплачено </th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if( isset($recent_invoices))
					{
						foreach ($recent_invoices as $count => $invoice)
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
						<td class="text-right"><?php
						echo $this->config->currency_symbol.number_format($invoice['total_paid'], 2); ?>
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
					<td></td>
					<td></td>
					</tr>
					<?php
					}
					?>
                    </tbody>
                  </table>
                </div>
                <div class="text-right">
                  <a href="<?php echo site_url('invoices');?>">Показать все счета <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->