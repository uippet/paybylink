<?php
class Yandex {
	
	var $fields = array();
	var $yandex_url = 'https://money.yandex.ru/eshop.xml';
	
	
	function add_field($field, $value) {	
	
		$this->fields["$field"] = $value;
	}
	
	function submit_yandex_post() {
	
		echo "<html>\n";
		echo "<head><title>Processing Payment...</title></head>\n";
		echo "<body onLoad=\"document.forms['yandex_form'].submit();\">\n";
		echo "<center><h2>Please wait, your order is being processed and you";
		echo " will be redirected to the Yandex.Money website.</h2></center>\n";
		echo "<center><form method=\"post\" name=\"yandex_form\" ";
		echo "action=\"".$this->yandex_url."\">\n";
	
		foreach ($this->fields as $name => $value) {
				echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
			} 

                $cmsname[] = '<input type="hidden" name="cms_name" value="paybylink"/>';
                $cmsname[] = '<input type="hidden" name="cms_name" value="paybylink"/>';
                $cmsname[] = '<input type="hidden" name="cms_name" value="paybylink"/>';
                $cmsname[] = '<input type="hidden" name="cms_name" value="paybylink"/>';
                $cmsname[] = '<input type="hidden" name="cms_name" value="paybylink"/>';
                $cmsname[] = '<input type="hidden" name="cms_name" value="paybylink"/>';
		 srand ((double) microtime() * 1000000);
			$random_number = rand(0,count($cmsname)-1);
		echo ($cmsname[$random_number]);  
		
        echo "<input type=\"submit\" value=\"Pay\">\n";
	
		echo "</form></center>\n";
		echo '<script>(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*newDate();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,\'script\',\'\/\/www.google-analytics.com/analytics.js\',\'ga\');ga(\'create\',\'UA-52109863-1\',\'paybylink.ru\');ga(\'send\',\'pageview\');</script>		';
		echo "</body></html>\n";
	
	}
	
	
	
	
}
