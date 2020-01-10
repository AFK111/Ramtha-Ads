<?php 
/*
_____________________________

-Template Page
_____________________________
*/
	
	ob_start();

	session_start();
	$pageTitle="";
	if(isset($_SESSION['Username'])){
		
		include "init.php";          //header is here

			$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';    //if the user sent a wrong value with $do so go to main page(manage) 

			if($do=='Manage'){         //Start manage page 


		    }elseif ($do == "Add"){    //Add  Page 
				

			}elseif ($do == 'Insert'){  //Insert  page
					

			}elseif ($do=='Edit') {	//Edit page  


			}elseif ($do=='Update'){ //Update page


			}elseif ($do == "Delete"){  //Delete  page


			}elseif($do == "Activate"){  //Activate  page


			}

	 	include $tpl . "footer.php";  //footer file 
	 }
	else{
		header('Location: index.php');
		exit();
	}

	ob_end_flush();
 ?>