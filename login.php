<?php 
	session_start();
	$pageTitle="Login";
	if(isset($_SESSION['user']))
		header('Location:index.php'); // Redirect to index page (maybe to profile later)

	include 'init.php';

	//Check if user coming from http POST request
 	
 	if($_SERVER['REQUEST_METHOD']=='POST'){
 		$user=$_POST['username'];
 		$pass=$_POST['password'];
 		$hashedPass=sha1($pass);
 		

 		
 		//Check if the user in the database

 		$stmt = $con->prepare("SELECT username , password FROM users WHERE username=? AND password=?");        //prepare before enter to DB (more safe)
 		$stmt->execute(array($user,$hashedPass));
 		$row=$stmt->fetch();
 		$count=$stmt->rowCount();

 		//if count > 0 this mean the DB contains info about this username

 		if($count>0)
 		{
 			$_SESSION['user']=$row['username']; //Register session name (for ordinary user)
 			header('Location:index.php'); //Redirect to index page
 			exit();
 		}
 	}

?>

	<div class="container login-page"> <!-- login-page used just as a parent to other classes -->
		<h1 class="text-center">  
			<span class="selected" data-class="login"><?php echo lang("LOGIN"); ?></span>
			 <b style="color:black;">|</b> 
			 <span data-class="signup"><?php echo lang("SIGNUP"); ?></span>
		</h1>

		<!-- Start login form -->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<!-- Start username field -->
			<input
			 type="text" 
			 name="username" 
			 autocomplete="off"  
			 class="form-control"
			 placeholder="<?php echo lang("USERNAME"); ?>" />
			 <!-- End username field -->
			
			<!-- Start password field -->
			<div style="position: relative;">
			<input
			 type="password" 
			 name="password" 
			 autocomplete="new-password" 
			 class="form-control password" 
			 placeholder="<?php echo lang("PASSWORD"); ?>"/>
			  <i class="show-pass fa fa-eye fa-2x"></i>
			</div>
			<!-- End password field -->

			<!-- Start submit field -->
			<input
			 type="submit" 
			 value="<?php echo lang("LOGIN"); ?>" 
			 class="btn btn-primary btn-block" />
			<!-- End username field -->

		</form>

		<!-- End login form -->

		<!-- Start singup form -->
		<form class="signup">
			<!-- Start username field -->
			<input
			 type="text" 
			 name="username" 
			 autocomplete="off"  
			 class="form-control"
			 placeholder="<?php echo lang("USERNAME"); ?>" />
			 <!-- End username field -->

			 <!-- Start password field -->
			 <div style="position: relative;">
			<input
			 type="password" 
			 name="password" 
			 autocomplete="new-password" 
			 class="form-control password" 
			 placeholder="<?php echo lang("PASSWORD"); ?>"/>
			 <i class="show-pass fa fa-eye fa-2x"></i>
			 </div>
			 <!-- End password field -->

			 <!-- Start Repassword field -->
			 <div style="position: relative;">
			 <input
			 type="password" 
			 name="repassword" 
			 autocomplete="new-password" 
			 class="form-control password" 
			 placeholder="<?php echo lang("REPASSWORD"); ?>"/>
			 <i class="show-pass fa fa-eye fa-2x"></i>
			</div>
			<!-- End Repassword field -->

			<!-- Start email field -->
			 <input
			 type="email" 
			 name="email" 
			 class="form-control" 
			 placeholder="<?php echo lang("EMAIL"); ?>"/>
			<!-- End email field -->

			<!-- Start submit field -->
			<input
			 type="submit" 
			 value="<?php echo lang("SIGNUP"); ?>" 
			 class="btn btn-success btn-block" />
			 <!-- End submit field -->
		</form>
		<!-- End singup form -->
	</div>



<?php include $tpl .'footer.php'; ?>