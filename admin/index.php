<?php
	session_start();
	$noNavbar="";
	$pageTitle="Login";
	if(isset($_SESSION['Username']))
		header('Location:dashboard.php'); //Redirect to dashboard page

 	include "init.php";

 	//Check if user coming from http POST request
 	
 	if($_SERVER['REQUEST_METHOD']=='POST'){
 		$username=$_POST['user'];
 		$password=$_POST['pass'];
 		$hashedPass=sha1($password);
 		
 		//Check if the user in the database

 		$stmt = $con->prepare("SELECT userid, username , password FROM users WHERE username=? AND password=? AND groupid=1");        //prepare before enter to DB (more safe)
 		$stmt->execute(array($username,$hashedPass));
 		$row=$stmt->fetch();
 		$count=$stmt->rowCount();

 		//if count > 0 this mean the DB contains info about this username

 		if($count>0)
 		{
 			$_SESSION['Username']=$row['username']; //Register session name(for admin)
 			$_SESSION['ID']= $row['userid']; //Register session ID
 			header('Location:dashboard.php'); //Redirect to dashboard page
 			exit();
 		}
 	}
?>			

			<div>
				<img src="layout/images/HiLogo.png" class="image-center img-fluid img-login" alt="HiLogo">
			</div>
			<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				
				<h3 class="text-center"><?php echo lang("ADMIN_LOGIN"); ?> </h3>
				<input class="form-control input-lg" type="text" name="user" placeholder="Userrname" autocomplete="off" />
				<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
				<input class="btn btn-primary btn-block btn-lg" type="submit" value="Login">
			</form>
		

 <?php 	include $tpl . "footer.php";  //footer file ?>   