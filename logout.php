<?php 
	
	
	session_start();    //start the session
	unset($_SESSION['user']);

	//session_unset();    //unset the data in the session
	//session_destroy();  //destroy all the session

	header('Location:index.php');
	exit();  // to prevent error if the header is wrong
 ?>