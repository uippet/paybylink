<script type="text/javascript">
$(function() {
	$('.loading').fadeIn('slow');
	$('.report-header').html('Payment Summary');
	$.post("<?php echo site_url('reports/payment_summary'); ?>", {
			shop: 'all',
			from_date: '',
			to_date: '',
		},
		function(data) {
		   $('#report-body').html(data);
		   $('.loading').fadeOut('slow');
		});
});
//function to generate payments summary report
function payments_summary()
{
	var shop 		= $('#shop_id').val();
	var from_date 	= $('#from_date').val();
	var to_date 	= $('#to_date').val();
	
	if(shop == '')
	{
		shop 		= 'all';
	}
	$('.loading').fadeIn('slow');
	$.post("<?php echo site_url('reports/payment_summary'); ?>", {
			shop		: shop,
			from_date	: from_date,
			to_date		: to_date,
		},
		function(data) {
		   $('#report-body').html(data);
		    $('.loading').fadeOut('slow');
		});
}

//function to generate payments summary report
function payments_history()
{
	var from_date 	= $('#from_date').val();
	var to_date 	= $('#to_date').val();
	
	$('.loading').fadeIn('slow');
	$.post("<?php echo site_url('reports/payment_history'); ?>", {
		from_date	: from_date,
		to_date		: to_date,
		},
		function(data) {
		   $('#report-body').html(data);
		    $('.loading').fadeOut('slow');
		});
}


//function to generate client statement
function client_statement()
{
	$('.loading').fadeIn('slow');
	var client 		= $('#client_id').val();
	$.post("<?php echo site_url('reports/client_statement'); ?>", {
		client_id : client,
		},
		function(data) {
		   $('#report-body').html(data);
		    $('.loading').fadeOut('slow');
		});
}
//function to generate invoice report
function invoices_report()
{
	$('.loading').fadeIn('slow');
	var client 		= $('#client_id').val();
	$.post("<?php echo site_url('reports/invoices_report'); ?>", {
		client_id : client,
		},
		function(data) {
		   $('#report-body').html(data);
		    $('.loading').fadeOut('slow');
		});
}
//function to display clients contact list
function clients_contact_list()
{
	$('.loading').fadeIn('slow');
	$.post("<?php echo site_url('reports/clients_contact_list'); ?>", {},
		function(data) {
		   $('#report-body').html(data);
		    $('.loading').fadeOut('slow');
		});
}
</script>
<div class="loading"></div>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<button type="button" class="btn btn-primary btn-lg reports-button" onclick="javascript: payments_summary();">Статистика по магазину</button> 
			<button type="button" class="btn btn-danger btn-lg reports-button" onclick="javascript: payments_history();">Платежи по платежным страницам</button>
			<button type="button" class="btn btn-info btn-lg reports-button" onclick="javascript: client_statement();">Статистика по клиенту</button>
			<button type="button" class="btn btn-warning btn-lg reports-button" onclick="javascript: clients_contact_list();">Ваши клиенты</button>
		</div> 
	</div>

		
	 <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="table-responsive">
				<div id="report-body"></div>
				</div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
</div> 
