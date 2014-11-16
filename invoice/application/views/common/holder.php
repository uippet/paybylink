<?php 
$config = get_business_config();
$this->config->currency_symbol = (!empty($config) && $config->currency !='') ? $config->currency.' ' : ' RUB ';
?>

<?php $this->load->view('common/header'); ?>
<div id="wrapper">
<!-- Sidebar -->
<?php $this->load->view('common/navigation'); ?>      
<?php $this->load->view($pagecontent); ?> 
</div><!-- /#wrapper -->
<?php $this->load->view('common/footer'); ?>
    
