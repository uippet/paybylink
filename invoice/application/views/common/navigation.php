<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
		 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">PayByLink.RU</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">PayByLink.RU</a> 
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
		
          <ul class="nav navbar-nav side-nav">
			<li style="width:auto;background:lime"><a href="https://www.facebook.com/paybylink/posts/784595448253882"><i class="fa fa-cogs"></i> Новость дня</a></li>
			<li <?=(isset($activemenu) && $activemenu == 'dashboard') ? 'class="active"' : ''?>><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Дашборд </a></li>
            <li <?=(isset($activemenu) && $activemenu == 'invoices') ? 'class="active"' : ''?>><a href="<?php echo site_url('invoices'); ?>"><i class="fa fa-usd"></i> Счета </a></li>
            <li <?=(isset($activemenu) && $activemenu == 'clients') ? 'class="active"' : ''?>><a href="<?php echo site_url('clients'); ?>"><i class="fa fa-user"></i> Клиенты </a></li>
            <li <?=(isset($activemenu) && $activemenu == 'products') ? 'class="active"' : ''?>><a href="<?php echo site_url('products'); ?>"><i class="fa fa-money"></i> Продукты </a></li>
            <li <?=(isset($activemenu) && $activemenu == 'reports') ? 'class="active"' : ''?>><a href="<?php echo site_url('reports'); ?>"><i class="fa fa-eye"></i> Отчеты </a></li>
<?php
$cookie_name = '1server'; if(!isset($_COOKIE[$cookie_name])) { echo'<li style="width:auto;background:none"><a href="http://yasobe.ru/na/server"><i class="fa fa-bug"></i> We need you help</a></li>';}
?>
          </ul>
          <ul class="nav navbar-nav navbar-right navbar-user">
		  
		  
		  <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i> Настройки <b class="caret"></b></a>
              <ul class="dropdown-menu">
              <?php if($this->session->userdata('level') == 1) : ?>
                <li><a href="<?php echo site_url('users'); ?>"><i class="fa fa-user"></i> Управление пользователями </a></li>
                <li class="divider"></li>
				 <li><a href="<?php echo site_url('shops'); ?>"><i class="fa fa-th-list"></i> Мои магазины </a></li>
                <li class="divider"></li>
				<li><a href="<?php echo site_url('payment_page'); ?>"><i class="fa fa-usd"></i> Платежные страницы </a></li>
				 <li class="divider"></li>
                <li><a href="<?php echo "#"/*site_url('api')*/; ?>"><i class="fa fa-cog"></i> API (в разработке) </a></li>
                <li class="divider"></li>
                <li><a href="<?php echo site_url('settings'); ?>"><i class="fa fa-cog"></i> Настройки организации </a></li>
               <?php else : ?>
               <li class="divider"></li>
               <li><a href="<?php echo site_url('payment_page'); ?>"><i class="fa fa-usd"></i> Платежные страницы </a></li>
                <?php endif; ?>
              </ul>
            </li>
           
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <i class="fa fa-user"></i> <?php echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname')); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('account/myprofile'); ?>"><i class="fa fa-user"></i> Ваш профиль </a></li>
                <li class="divider"></li>
                <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-power-off"></i> Выйти </a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
