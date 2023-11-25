<?php
$otpKey = checkRequiredVar('otp-key');
if( !$otpKey ){
	die('otp-key is missing');
}
$otpToken = checkRequiredVar('otp-token');
if( !$otpToken ){
	die('otp-token is missing');
}

$status = verifyOneTimeLogin( $otpKey, $otpToken );
if( !$status ){
	die('not authorized!');
}


header('Content-Type:text/html; charset=ISO-8859-15'); //needed for html pages

phpinfo();