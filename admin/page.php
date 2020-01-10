<?php 

	// Categories => [Manage | Edit | Update | Add | Insert | Delete | Stats]

	$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';    //if the user sent a wrong value with $do so go to main page(manage) 
	
	//if the page is the main page

	if($do=='Manage'){
		echo "Manage Category :  ";
		echo "<a href='page.php?do=Add'>Add new category +</a>";
	}elseif ($do=='Add') {
		echo "Add Category";
	}elseif($do == 'Insert'){
		echo "insert Category";
	}else{
		echo "Error : there is no page with this name";
	}

 ?>