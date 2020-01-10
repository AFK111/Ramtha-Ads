<?php //this file make the website more dynamic 
		
	//Routes

	$tpl  = 'includes/templates/';    // Template directory
	$lang ='includes/languages/';     //language directory
	$func = 'includes/functions/';    //functions directory
	$css  = 'layout/css/';            //css directory
	$js   = 'layout/js/';             //js directory
	

	//includes important files
	include $func . "/functions.php";
	include $lang . "english.php";
	include 'connect.php';
	include    $tpl . "header.php"; 	
	
	if(!isset($noNavbar))                      //include navbar in all pages except that contains noNavbar variable
		include    $tpl . "navbar.php";


	
 ?>