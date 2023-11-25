<?php

if( !defined('DIRECTACCESS') ){
	define('DIRECTACCESS', true);
}
define( 'HOME_DIR_PATH', '/var/www/landlord/worker/' );


session_start(); //start the session
if ( isset($_SESSION['loggedin']) ) {
	unset( $_SESSION['loggedin'] ); //logout
	header('Location: index.php');
	exit;
}

//if we are here it means the user is not logged in.

//first check for local env var
$envVarsFilePath = '/var/www/env-vars-controller-local.ini';
if( !file_exists($envVarsFilePath) ) {
	
	$envVarsFilePath = '/var/www/env-vars-controller.ini';
	if( !file_exists($envVarsFilePath) ) {
		echo getcwd().' Please setup '.$envVarsFilePath;
		die;
	}
	
}
$evnVars = parse_ini_file( $envVarsFilePath, false, INI_SCANNER_TYPED );

define( 'COMPOSER_AUTOLOAD_FILE_PATH', 		$evnVars['COMPOSER_AUTOLOAD_FILE_PATH'] );
//define databse connection here
define( 'WAAS1_CONTROLLER_DB_HOST', 		$evnVars['WAAS1_CONTROLLER_DB_HOST'] );
define( 'WAAS1_CONTROLLER_DB_NAME', 		$evnVars['WAAS1_CONTROLLER_DB_NAME'] );
define( 'WAAS1_CONTROLLER_DB_USER', 		$evnVars['WAAS1_CONTROLLER_DB_USER'] );
define( 'WAAS1_CONTROLLER_DB_PASSWORD', 	$evnVars['WAAS1_CONTROLLER_DB_PASSWORD'] );
define( 'THIS_ENV_IS_LOCAL', 				$evnVars['THIS_ENV_IS_LOCAL'] );


//require composer autoload
chdir( dirname(__FILE__) ); //Change the working directory to the running file path. Just use
require_once( COMPOSER_AUTOLOAD_FILE_PATH );

$db = new Zebra_Database();
$db->debug = false;
$db->resource_path = '/';
$db->connect( WAAS1_CONTROLLER_DB_HOST, WAAS1_CONTROLLER_DB_USER, WAAS1_CONTROLLER_DB_PASSWORD, WAAS1_CONTROLLER_DB_NAME ); //providing port is important now.

$platFormBranding = getPlatFormBranding( $db );





$currentPage = 'login';
$currentTitle = 'Login to the controller';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$redirectBack = true;
	$userId = false;
	$password = false;
	
    if( isset($_POST['userId']) && $_POST['userId'] !== '' ){
		$userId = $_POST['userId'];
	}
	
	if( isset($_POST['password']) && $_POST['password'] !== '' ){
		$password = $_POST['password'];
	}

	if( $userId && $password ){
		$redirectBack = false;
	}
	
	if( $redirectBack ){
		header('Location: login.php');
		exit;
	}

}

?>



<!doctype html>
<html lang="en">
	<head>
	
		<?php require_once( 'blocks/header-10.php' ); ?>
		
		
		
		<style>
		  .bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		  }
		  
		  .platformLogo{
			  max-width: 265px;
		  }

		  @media (min-width: 768px) {
			.bd-placeholder-img-lg {
			  font-size: 3.5rem;
			}
		  }
		  
		  body{
			  background: <?php echo $platFormBranding['PLATFORM_BRAND_BACKGROUND_COLOR']; ?>;
		  }
		</style>
	
	</head>
	

	<body>
	
	
	
	
	<main class="form-signin text-center">
		<form method="post" action="index.php">
		<img class="platformLogo mb-4" class="mb-4" src="<?php echo $platFormBranding['PLATFORM_BRAND_LOGO_URL']; ?>" />


		<div class="form-floating">
		  <input type="text" class="form-control" id="floatingInput" placeholder="User ID" name="userId">
		  <label for="floatingInput">User ID</label>
		</div>
		<div class="form-floating">
		  <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
		  <label for="floatingPassword">Password</label>
		</div>


		<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
		<input type="hidden" name="task" value="LOGIN_FROM_FRONTEND" />
		</form>
	</main>
	
	
	
	
<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	console.log( 'jQuery ready!' );
});
</script>


	</body>
</html>













<?php

function getPlatFormBranding( $db ){
	
	$returnArray = array();

	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_LOGO_URL') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_LOGO_URL'] = $result['value'];
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_LOGO_URL_BLACK') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_LOGO_URL_BLACK'] = $result['value'];
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_BACKGROUND_COLOR') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_BACKGROUND_COLOR'] = $result['value'];
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_BACKGROUND_COLOR_BLACK') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_BACKGROUND_COLOR_BLACK'] = $result['value'];
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_PRIMARY_COLOR') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_PRIMARY_COLOR'] = $result['value'];
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_PRIMARY_COLOR_BLACK') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_PRIMARY_COLOR_BLACK'] = $result['value'];
	
	
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_SITE_URL') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_SITE_URL'] = $result['value'];
	
	$db->select( 'value', 'options', 'name = ?', array('PLATFORM_BRAND_NAME') );
	$result = $db->fetch_assoc();
	$returnArray['PLATFORM_BRAND_NAME'] = $result['value'];
	


	
	return $returnArray;
}

?>