<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'');
define('FOPEN_READ_WRITE',						'');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		''); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	''); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'');
define('FOPEN_READ_WRITE_CREATE',				'');
define('FOPEN_WRITE_CREATE_STRICT',				'');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'');

define('CSSFOLDER',						'');
define('JAVASCRIPTFOLDER',				'');
define('IMAGESFOLDER',					'');
define('FONTSFOLDER',					'');
define('UPLOADSDIR',					'');
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');



/* End of file constants.php */
/* Location: ./application/config/constants.php */