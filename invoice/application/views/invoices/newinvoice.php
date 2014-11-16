 <script type="text/javascript">
	    $(function() {
        <?php if (!isset($items)) { ?>
            $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>
		});
 </script>
 <div class="loading"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="well invoice_menu navbar navbar-fixed-top">
			<a href="javascript: void(0);" class="btn btn-large btn-primary" id="bttn_add_item"><i class="fa fa-plus"></i> Добавить позицию</a>
			<a href="javascript: void(0);" class="btn btn-large btn-info" id="bttn_add_product"><i class="fa fa-plus"></i> Добавить позицию из сохраненных</a>
		</div>
	</div>
</div>

 <div id="page-wrapper">
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
          <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top:70px">
              <div class="panel-body">
                <div class="table-responsive">
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-default col-lg-10">
							  <div class="panel-body">
							  <input type="hidden" id="invoice_status" name="invoice_status" value="unpaid"/>
							  <input type="hidden" id="invoice_number" name="invoice_number" value=""/>
								<div class="form-group">
								<label>Выберите клиента </label>
								<select name="client_to_invoice" id="client_to_invoice" class="form-control"><?php echo $clients; ?></select>
								</div>							
							  </div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-default col-lg-10">
							  <div class="panel-body">
								<div class="form-group">
								<label>Выберите магазин из которого выставлять счет </label>
								<select name="invoice_shop" id="invoice_shop" class="form-control"><?php echo $shops; ?></select>
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
                    <th class="text-right">Цена за 1 штуку</th>
					<th class="text-right">Скидка</th>
					<th class="text-right">Стоимость <br/> (только по позиции)</th>
					<th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="new_item" style="display: none;">
					<input type="hidden" name="invoice_id" value="" id="invoice_id">
					<input type="hidden" name="item_id" value="">
                    <td style="width:20%"><input name="item_name" value="" class="form-control"/></td>
                    <td><textarea name="item_description" class="form-control"></textarea></td>
                    <td style="width:5%"><input class="form-control" onchange="javascript: calculateInvoiceAmounts();"  name="item_quantity" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_price" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_discount" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" readonly name="item_sub_total" value=""/></td>
                 	<td style="width:2%">
					<a href="javascript: void(0)" title="delete" onclick="$(this).parent().parent().remove()"><i class="fa fa-times"></i></a>
					</td>
                  </tr>
				</table>
				  <table class="table table-bordered">
				 				  <tr class="text-right" id="invoice_total_row">
                    <td colspan="6" class="no-border">Итого:</td>
                    <td style="width:12%;" ><label><?php echo $this->config->currency_symbol; ?><span id="items_total_cost">0.00</span></label></td>
				 </tr>
				 
					<tr class="text-right">
                    <td colspan="6" class="no-border" style="vertical-align: middle">Скидка на заказ :</td>
                    <td  style="width:12%;" >
					<div class="form-group input-group invoice_grand_total" style="margin-bottom: 0px">
						<span class="input-group-addon"><?php echo $this->config->currency_symbol; ?></span>
						<input type="text" class="form-control text-right invoice_grand_total" name="invoice_discount_amount" onchange="javascript: calculateInvoiceAmounts();"  id="invoice_discount_amount" value="0.00"/>
					 </div>
					</td>
                  </tr>
				  
				  <tr class="text-right">
                    <td colspan="6" class="no-border">Оплаченно : </td>
                    <td class="invoice_grand_total"><label><?php echo $this->config->currency_symbol; ?><span id="items_total_discount">0.00</span></label></td>
                  </tr>
				  <tr class="text-right">
                    <td colspan="6" class="no-border "> К оплате : </td>
                    <td class="invoice_amount_due"><label><?php echo $this->config->currency_symbol; ?><span id="invoice_amount_due">0.00</span></label></td>
                  </tr>
                </tbody>
              </table>
			  
			  <div class="form-group">
				<label> Комментарии </label>
				<textarea name="invoice_terms" class="form-control" id="invoice_terms"></textarea>
			  </div>
			  <a href="javascript: void(0);" onclick="javascript: ajax_save_invoice();" class="btn btn-large btn-success pull-right" id="bttn_save_invoice"><i class="fa fa-check"></i> Выставить счет на email</a>
            </div>
						</div>
					</div>
					
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
</div><!-- /#page-wrapper -->