<?php 
	
	//getTitle function v1.0
	function getTitle(){
		global $pageTitle;			// we will take this variable when we include this file and declare before it $pageTitle var

		if(isset($pageTitle))
			echo $pageTitle;
		else	
			echo lang("DEFAULT");
	}


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


	/*v1.0	
	** Function to get latest items from database [ Users , Items , Comments ]  [ This function has parameters ]
	** $select = field to select
	** $from = the table to choose from
	** $order = the field to sort the items with it 
	** $limit = number of records to get
	*/

	function getLatest($select , $from , $order , $limit = 5,$RegStatus){

		global $con;
		
		$getStmt = $con->prepare("SELECT $select FROM $from WHERE $RegStatus = 1 ORDER BY $order DESC  LIMIT $limit ");
		$getStmt->execute();
		$rows = $getStmt->fetchAll();

		return $rows;
	}

 ?>