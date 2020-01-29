<?php //this file make the website more dynamic 
		

	//Error reporting
	ini_set('display_errors','on');
	error_reporting(E_ALL);

	$sessionUser='';
	if( isset($_SESSION['user']) )
		$sessionUser=$_SESSION['user'];     //we declare this variable because if we print or use unfound $_SESSION['user'] ...
											//... deal with it as empty instead of undefined .
	//Routes

	$tpl  = 'includes/templates/';    // Template directory
	$lang ='includes/languages/';     //language directory
	$func = 'includes/functions/';    //functions directory
	$css  = 'layout/css/';            //css directory
	$js   = 'layout/js/';             //js directory
	

	//includes important files
	include $func . "/functions.php";
	include $lang . "english.php";
	include 'admin/connect.php';
	include    $tpl . "header.php";  //navbar is here	
	


	
 ?>