<?php 
	$dbName = getenv('DB_NAME');
	$host = getenv('DB_HOST');

	$dsn="mysql:host=$host;dbname=$dbName";
	$user = getenv('DB_USERNAME');
	$pass=getenv('DB_PASS1');
	$option=array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try{
		$con=new PDO($dsn,$user,$pass,$option);
		$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "You are connected welcome to database<br>";
	}
	catch(PDOException $e){
		echo 'Failed to connect : ' . $e->getMessage();
	}
 ?>