<?php

namespace Php_Error_Log_Viewer;


if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.
header('Content-Type:text/html; charset=ISO-8859-15');

/**
 * PHP Error Log Viewer.
 * Check readme.md for more information.
 *
 * Disclaimer
 * - This contains code for reading & deleting your log-file.
 * - Log files might contain sensitive information.
 * - It is meant for development-environments
 */




//setup required parameters

$siteId = checkRequiredVar( 'site-id' );
if( !$siteId ){
	echo 'Required parameter "site-id" not found. '. LINE_BREAK;
	exit(); //make sure to exit from here
}

if( $siteId  == 'n/a' ){
	echo 'No site id selected! '. LINE_BREAK;
	exit(); //make sure to exit from here
}



$logToView = checkRequiredVar( 'log' );




$key = checkRequiredVar('key');
if( !$key ){
	echo 'Required parameter "key" not found. '. LINE_BREAK;
	exit(); //make sure to exit from here
}

if( $key  == 'n/a' ){
	echo 'No key provided! '. LINE_BREAK;
	exit(); //make sure to exit from here
}


$envVarsFilePath = '/var/www/site'.$siteId.'/env-vars-dynamic.ini';
if( THIS_ENV_IS_LOCAL ){
	$envVarsFilePath = '/var/www/site'.$siteId.'/env-vars-dynamic-local.ini';
}
$evnVars = parse_ini_file( $envVarsFilePath, false, INI_SCANNER_TYPED );

$localKey = md5( $evnVars['WAAS1_DB_PASSWORD'].$siteId );

if( $key != $localKey ){
	echo 'Not authorized! '. LINE_BREAK;
	exit(); //make sure to exit from here
}




require_once '/var/www/landlord/worker/tasks/log-viewer/LogHandler.php';
require_once '/var/www/landlord/worker/tasks/log-viewer/AjaxHandler.php';

/*
$path = 'php-error-log-viewer.ini';
// search settings directly outside the vendor folder.
$settings = file_exists('../../' . $path) ? parse_ini_file('../../' . $path) : array();
// search settings in the same folder as the file.
$settings = file_exists($path) ? parse_ini_file($path) : $settings;
*/

$settings = array( 'file_path'=>WAAS1_MAIN_WP_CONTENT_DIR.'/site'.$siteId.'/logs/'.$logToView.'.log' );


$log_handler = new LogHandler($settings);


$ajax_handler = new AjaxHandler($log_handler);
$ajax_handler->handle_ajax_requests();


?>

<script>
	const SITE_ID 	= '<?php echo $siteId; ?>';
	const LOG_TO_VIEW = '<?php echo $logToView; ?>';
	const KEY = '<?php echo $key; ?>';
</script>


<?php
readfile(  '/var/www/landlord/worker/tasks/log-viewer/error-log-viewer-frontend.html' );