<?php 
		


	/*v2.0	
	** Function to get all records from any database table
	*/

	function getAll($field , $tableName , $where=null , $orderBy=null , $AD="DESC" ){

		global $con;

		if($where !== null)
			$where="WHERE" . " $where";
		
		if($orderBy	!== null) 
			$orderBy="ORDER BY" . " $orderBy $AD"  ;



		$getAll = $con->prepare("SELECT $field FROM $tableName $where $orderBy");
		$getAll->execute();
		$All = $getAll->fetchAll();

		return $All;
	}


	/*v1.0	
	** Function to get number of users
	*/

	function countUsers(){

		global $con;


		$getAll = $con->prepare("SELECT UserName FROM users");
		$getAll->execute();
		$All = $getAll->rowCount();

		return $All;
	}



	/*v1.0	
	** Function to check if the user is active or not
	** Return 1 if active and 0 if not 
	*/
	function checkUserStatus($user){

		global $con;

 		$stmt = $con->prepare("SELECT username , RegStatus FROM users WHERE username=? AND RegStatus=1"); 
 		$stmt->execute(array($user));
 		$status=$stmt->rowCount();

 		return $status;

	}





	//getTitle function v1.0
	function getTitle(){
		global $pageTitle;			// we will take this variable when we include this file and declare before it $pageTitle var

		if(isset($pageTitle))
			echo $pageTitle;
		else	
			echo lang("DEFAULT");
	}



	/*v1.0
	** Function to check item in database if exist or not [ This function has parameters ]
	** $select = the item to select [ Example : userName , item , category ]
	** $from = the table to select from [ Example : users , items , categories ] 
	** $where = the value of condition(The value to check) [ Example : osama , box , electornics , 12]
	*/

	function checkItem($select , $from , $where){

		global $con;                 // we will take this variable when we include this file and include before it 'connect' file that..
									 //.. contains the $con variable
		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
		$statement->execute(array($where));

		$count = $statement->rowCount();

		return $count;
	}


/*/////////////////////////////////////OLD FUNCTIONS (ADMIN FUNCTIONS)/////////////////////////////////////////////////////////////////////*/

	/*v2.0
	** Home Redirect function [ This function has parameters]
	** $theMsg = print the message [ error | success | warning]
	** $url = the link you want to redirect to 
	** $seconds = seconds before redirecting
	*/
	function redirectHome($theMsg , $url = null , $seconds = 3){   //the null with $url variable make it optional
		
		if($url === null)
			$url='index.php';
		elseif ($url === 'back')
			$url=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';     //HTTP_REFERER means the page that I was in before this page..
																							   //If you come directly with back page the  HTTP_REFERER ..
																							   //will be unset .	

		echo  $theMsg ;
	
		header("refresh:$seconds;url=$url");
		exit();
	}



	/*v1.0
	** Function to count number of specific thing [ This function has parameters ]
	** $item = the item(column) to count
	** $table = the table to count from
	*/

	function countItems($item , $table){

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		$stmt2->execute();

		return $stmt2->fetchColumn();
	}


	

 ?>