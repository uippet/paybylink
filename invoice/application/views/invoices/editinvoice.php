 <script type="text/javascript">
	    $(function() {
        <?php if (!isset($invoice_items) || empty($invoice_items)) { ?>
            $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>
		});
 </script>
 <div class="loading"></div>
<!--<div class="row">
	<div class="col-lg-12">
		<div class="well invoice_menu navbar navbar-fixed-top">
			  <a href="javascript: void(0);" onclick="delete_invoice('<?php echo $invoice_details->invoice_id; ?>');" class="btn btn-large btn-danger pull-right" id="bttn_delete_invoice" ><i class="fa fa-times"></i> Delete Invoice</a>
			
		</div>
	</div>
</div>--> 
 <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
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
					<div class="row">
						<div class="col-lg-6">
						<h3> Номер счета : # <?php echo $invoice_details->invoice_number; ?> </h3>
							<div class="panel panel-default col-lg-10">
							  <div class="panel-body">
							  <input type="hidden" id="invoice_number" name="invoice_number" value="<?php echo $invoice_details->invoice_id; ?>"/>
							  <input type="hidden" id="invoice_shop" name="invoice_shop" value="<?php echo $invoice_details->shop_id; ?>"/>
								<div class="form-group">
								<label>Клиент </label>
								<select name="client_to_invoice" disabled id="client_to_invoice" class="form-control"><?php echo $clients; ?></select>
								</div>
								<div class="form-group">
								<label>Магазин </label>
								<select name="client_to_invoice" disabled id="client_to_invoice" class="form-control"><?php echo $shops; ?></select>
								</div>
								<div class="form-group">
								<a href="javascript: void(0);" onclick="emailclient('<?php echo $invoice_details->invoice_id; ?>')" class="btn btn-large btn-success pull-right"  style="margin-right:10px"><i class="fa fa-envelope"></i> Повторить отправку письма </a>
								</div>
							  </div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel-default col-lg-12">
							
							  <div class="panel-body">
							  <?php
							  if($invoice_details->invoice_status == 'UNPAID'){ $class = 'invoice_status_unpaid'; }
							  if($invoice_details->invoice_status == 'PAID'){ $class = 'invoice_status_paid'; }
							  if($invoice_details->invoice_status == 'CANCELLED'){ $class = 'invoice_status_cancelled'; }
							  ?>
							<div class="<?php echo $class; ?> pull-right"> <?php echo $invoice_details->invoice_status; ?></div>
							<div style="clear: both"></div>
							<div class="form-group invoice_change_status pull-right">
							<label>Изменить статус вручную : </label>
								<select class="form-control" name="invoice_status" id="invoice_status">
								<option value="paid" <?php echo ($invoice_details->invoice_status == 'PAID') ? 'selected' : ''; ?>> ОПЛАЧЕНО </option>
								<option value="unpaid" <?php echo ($invoice_details->invoice_status == 'UNPAID') ? 'selected' : ''; ?>> НЕОПЛАЧЕНО </option>
								<option value="cancelled" <?php echo ($invoice_details->invoice_status == 'CANCELLED') ? 'selected' : ''; ?>> АННУЛИРОВАН </option>
								</select>
							</div>	
								
							  </div>
							  <div class="invoice_actions pull-right">
							  <div class="form-group">
							  <a href="javascript: void(0);" onclick="enterPayment('<?php echo $invoice_details->invoice_id; ?>')" class="btn btn-large btn-primary" id="bttn_enter_payment"><i class="fa fa-usd"></i> Ввести сумму</a>
							  <a href="javascript: void(0);" class="btn btn-large btn-info" id="bttn_view_pdf" onclick="viewInvoice('<?php echo $invoice_details->invoice_id; ?>')"><i class="fa fa-search"></i> Показать счет </a>
							  </div>
							
							  </div>
							</div>
						</div>
						
					</div>
		<div class="row">
			<div class="col-lg-12">
				<h4>Счет</h4>	
			<div class="table-responsive">			
              <table id="item_table" class="table table-bordered">
                <thead>
                  <tr class="table_header">
                    <th>Название товара или услуги</th>
                    <th>Описание</th>
                    <th>Количество</i></th>
                    <th class="text-right">Цена за штуку</th>
					<th class="text-right">Скидка</th>
					<th class="text-right">Стоимость <br/> (только по позиции)</th>
                  </tr>
                </thead>
                <tbody>
					<tr id="new_item" style="display: none;">
					<td style="width:20%">
					<input type="hidden" name="invoice_id" value="<?php echo $invoice_details->invoice_id; ?>" id="invoice_id">
					<input type="hidden" name="item_id" value="">
					<input name="item_name" value="" class="form-control"/></td>
					<td style="width:25%"><textarea name="item_description" class="form-control"></textarea></td>
					<td style="width:5%"><input class="form-control" onchange="javascript: calculateInvoiceAmounts();"  name="item_quantity" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_price" value=""/></td>
					<td class="text-right" style="width:8%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_discount" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" readonly name="item_sub_total" value=""/></td>
					</tr>
				  <?php 
					$subtotal = 0;
					$taxtotal = 0;
					$item_discount_total = 0;
					if(isset($invoice_items))
					{
						foreach($invoice_items as $item)
						{
					?>
						<tr id="item" class="item">
						<td style="width:20%">
						<input type="hidden" name="invoice_id" value="<?php echo $invoice_details->invoice_id; ?>">
						<input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
						<input name="item_name" readonly value="<?php echo $item['item_name']; ?>" class="form-control"/>
						</td>
						<td style="width:25%"><textarea name="item_description" readonly class="form-control"><?php echo $item['item_description']; ?></textarea></td>
						<td style="width:10%"><input class="form-control" readonly onchange="javascript: calculateInvoiceAmounts();"  name="item_quantity" value="<?php echo $item['item_quantity']; ?>"/></td>
						<td class="text-right" style="width:10%"><input class="form-control text-right" readonly onchange="javascript: calculateInvoiceAmounts();"  name="item_price" value="<?php echo $item['item_price']; ?>"/></td>
						
						<td class="text-right" style="width:8%"><input class="form-control text-right" readonly onchange="javascript: calculateInvoiceAmounts();"  name="item_discount" value="<?php echo $item['item_discount']; ?>"/></td>
						<td class="text-right" style="width:10%"><input class="form-control text-right" readonly onchange="javascript: calculateInvoiceAmounts();"  name="item_sub_total" readonly value="<?php echo $item['item_price'] - $item['item_discount']; ?>"/></td>
						</tr>
					<?php
						$subtotal = $subtotal + $item['item_total'];
						$item_discount_total += $item['item_discount'];
						}
					}
				  ?>

				  </tbody>
				  </table>
			
			<table class="table table-bordered">
					<tr class="text-right" id="invoice_total_row">
                    <td colspan="5" class="no-border">Итого:</td>
                    <td style="width:12%;" ><label><?php echo $this->config->currency_symbol; ?><span id="items_total_cost"><?php echo number_format($subtotal, 2); ?></span></label></td>
				 </tr>
				 
					<tr class="text-right">
                    <td colspan="5" class="no-border" style="vertical-align: middle">Скидка на заказ :</td>
                    <td  style="width:12%;" >
					<?php echo $this->config->currency_symbol; ?> <?php echo number_format($invoice_details->invoice_discount, 2); ?>
					</td>
                  </tr>
				  
				  <tr class="text-right">
                    <td colspan="5" class="no-border">Оплачено : </td>
                    <td class="invoice_grand_total"><label><?php echo $this->config->currency_symbol; ?><span id="items_total_discount">
					<?php 
					$total_paid = 0;
					foreach($invoice_payments->result_array() as $payment_count=>$payment)
					{
						$total_paid = $total_paid + $payment['payment_amount'];
					}
					echo number_format($total_paid, 2);
					?>
					</span></label></td>
                  </tr>
				  <tr class="text-right">
                    <td colspan="5" class="no-border"> К оплате : </td>
					<?php
					$amount_due = $subtotal - $invoice_details->invoice_discount + $taxtotal - $total_paid;
					$class = ($amount_due > 0) ? 'invoice_amount_due' : 'invoice_grand_total';
					?>
                    <td class="<?php echo $class; ?>"><label><?php echo $this->config->currency_symbol; ?><span id="invoice_amount_due">
					<?php echo number_format($amount_due, 2); ?>
					</span></label></td>
                  </tr>
			
			</table>
			  
			<h4> История платежей по заказу </h4> <hr/>
			  <table class="table table-striped table-bordered">
				<thead>
					<tr class="table_header">
						<th>Дата</th>
						<th>Сумма</th>
						<th>Комментарий</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($invoice_payments) && $invoice_payments->num_rows() > 0)
					{
						foreach($invoice_payments->result_array() as $count=>$payment){
					?>
					<tr>
					<td><?php echo date('d/m/Y', strtotime($payment['payment_date'])); ?> </td>
					<td><?php echo $this->config->currency_symbol; ?><?php echo number_format($payment['payment_amount'], 2); ?></td>
					<td><?php 
					$payment_method = '';
					
					if($payment['payment_method'] == 'PC') : 
						$payment_method = ' (Яндекс.Деньги)';
					elseif ($payment['payment_method'] == 'AC') :
						$payment_method = ' (Кредитная карта)';
					elseif ($payment['payment_method'] == 'MC') :	
						$payment_method = ' (Со счета мобильного телефона)';
					elseif ($payment['payment_method'] == 'GP') :
						$payment_method = ' (Терминал оплаты)';
					elseif ($payment['payment_method'] == 'WM') :
						$payment_method = ' (WebMoney)';
					endif;
					
					echo $payment['payment_note']  . $payment_method; 
					?>
					</td>
					</tr>
					<?php
					}
					} else {
					?>
					<tr>
					<td colspan="4">Пока по этому счету не было платежей.</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
				<hr/>		  
			  <div class="form-group">
			  <h4> Комментарии </h4> 
				<?php echo $invoice_details->invoice_terms; ?>
			  </div>
			  <a href="javascript: void(0);" onclick="javascript: ajax_save_invoice();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_save_invoice"><i class="fa fa-check"></i> Сохранить изменения</a>
			
            </div>
						</div>
					</div>
					
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
</div><!-- /#page-wrapper -->