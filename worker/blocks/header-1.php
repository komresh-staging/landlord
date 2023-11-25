<?php
if(!defined('DIRECTACCESS'))   die('Direct access not permitted'); //add this to every file included.

session_start(); //start the session

if( !isset($_SESSION['loggedin']) ){
	header('Location: login.php');
	exit;
}


?>