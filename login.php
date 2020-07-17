<?php 
	ob_start();
	session_start();
	$pageTitle="Login";
	if(isset($_SESSION['user']))
		header('Location:index.php'); // Redirect to index page (maybe to profile later)

	include 'init.php';

	//Check if user coming from http POST request
 	
 	if($_SERVER['REQUEST_METHOD']=='POST'){

		if(isset($_POST['login'])){  //login
	 		$user=$_POST['username'];
	 		$pass=$_POST['password'];
	 		$hashedPass=sha1($pass);
	 		

	 		
	 		//Check if the user in the database

	 		$stmt = $con->prepare("SELECT UserID,username , password FROM users WHERE username=? AND password=?");        //prepare before enter to DB (more safe)
	 		$stmt->execute(array($user,$hashedPass));
	 		$row=$stmt->fetch();
	 		$count=$stmt->rowCount();

	 		//if count > 0 this mean the DB contains info about this username

	 		if($count>0)
	 		{
	 			$_SESSION['user']=$row['username']; //Register session name (for ordinary user)
	 			$_SESSION['userid']=$row['UserID']; //Register user id in session
	 			header('Location:index.php'); //Redirect to index page
	 			exit();
	 		}
	 	}else{  //signup  
			 
			// Upload variables

			$avatarName=$_FILES['avatar']['name'];
			$avatarSize=$_FILES['avatar']['size'];
			$avatarTmp =$_FILES['avatar']['tmp_name'];
			$avatarType=$_FILES['avatar']['type'];
			$avatarErr =$_FILES['avatar']['error'];


			//list of allowed file types to upload  (to prevent the user upload any thing except images)
					
			$allowedExtension = array("jpeg" , "jpg" , "png" , "gif");

			// Get avatar extension
			$arr=explode(".",$avatarName);
			$avatarExtension = end($arr);  //end get the last value in an array
			$avatarExtension=strtolower($avatarExtension);


	 		$username=$_POST['username'];
	 		$pass1=$_POST['password'];
	 		$pass2=$_POST['repassword'];
	 		$email=$_POST['email'];

	 		$formErrors=array();

			 if(empty($avatarName)){
				$formErrors['avatar']=lang('ERR_AVATAR_EMP');
			}else if( ! in_array($avatarExtension ,$allowedExtension ) ){
				$formErrors['avatar']="must be [jpeg  , jpg , png , gif]";	
			}

			if( $avatarSize > (4 * 1024 * 1024) ){   //4MB
				$formErrors['avatar_size']="must be less than 4 MB";	
			}

	 		//filter and validate

	 		//username
	 		if( isset($username) ){
	 			$filterUser = filter_var($username , FILTER_SANITIZE_STRING );  //this because if the user put scripts or code in the username field , filter it.
	 		}

			if(strlen($filterUser)<3 || strlen($filterUser)>20){
				$formErrors['username']=lang('ERR_USERNAME');
			}

			//check if the user name exixst or not
			if(checkItem("UserName","users",$filterUser)){
				$formErrors['user_exist'] = lang('ERR_USER_EXIST');	
			}



			//password

	 		if( strlen($pass1)<5 || strlen($pass1)>300){
				$formErrors['password'] = lang('ERR_PASSWORD');
			}
			if($pass2 !== $pass1){
				$formErrors['repassword'] = lang('ERR_REPASS');	
			}
			$pass1=sha1($pass1);

			//email
			if( isset($email) ){
	 			$filterEmail = filter_var($email , FILTER_SANITIZE_EMAIL);  //this because if the user put scripts or code in the email field , filter it.
	 			
	 			if( filter_var($filterEmail , FILTER_SANITIZE_EMAIL) != true){
					$formErrors['email'] = lang('ERR_EMAIL');
				}
				
				if(!preg_match("/^[a-zA-Z][a-zA-Z0-9]+@[a-zA_Z]+\.[a-zA_Z]+$/", $filterEmail)){
					$formErrors['email'] = lang('ERR_EMAIL');
				}


				if(strlen($filterEmail)>200){
					$formErrors['email_len'] = lang('ERR_EMAIL_LEN');	
				}

	 		}

	 		if(count($formErrors)>0){   //if there are errors in the signup form
				$_SESSION['errors']=$formErrors;
				//Get the variables from the form to refill it in the form again
				$_SESSION['old_data']=$_POST;
			}else{// if no error in user data

				$avatar= rand(0,1000000) . '_' . $avatarName;

				move_uploaded_file($avatarTmp, "admin\uploads\avatars\\" . $avatar);

				$stmt=$con->prepare("INSERT INTO users(UserName , Password , Email , GroupID , RegStatus , Date , Avatar ) 
											VALUES(:zuser, :zpass , :zmail , 0 , 0 , now() , :zavatar)");
						$stmt->execute(array(
							':zuser' => $filterUser,
							':zpass' => $pass1,
							':zmail' => $filterEmail,
							'zavatar'=> $avatar,
						));
				$_SESSION['success_reg']=lang("MSG_SUCCESS_REG");	
				header("Location: login.php");	
				exit();
			}	

	 		

			}//signup


	 	}//request method==post
 	

?>

<div class="container login-page"> <!-- login-page used just as a parent to other classes -->
	<h1 class="text-center">  
		<span class="<?php if(!isset($_POST['signup']))echo 'selected'?>" data-class="login"><?php echo lang("LOGIN"); ?></span>
		 <b style="color:black;">|</b> 
		 <span class="<?php if(isset($_POST['signup']))echo 'selected'?>"  data-class="signup" id="signup"><?php echo lang("SIGNUP"); ?></span>
	</h1>

<!-- Start login form -->
<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="<?php if(isset($_POST['signup']))echo 'display: none;'?>" >
	<!-- Start username field -->
	<input
	 type="text" 
	 name="username"   
	 class="form-control"
	 placeholder="<?php echo lang("USERNAME"); ?>" 
	 />
	 <!-- End username field -->

	<!-- Start password field -->
	<div style="position: relative;">
	<input
	 type="password" 
	 name="password" 
	 autocomplete="new-password" 
	 class="form-control password" 
	 placeholder="<?php echo lang("PASSWORD"); ?>"
	 />
	  <i class="show-pass fa fa-eye fa-2x"></i>
	</div>
	<!-- End password field -->

	<!-- Start submit field -->
	<input
	 type="submit" 
	 value="<?php echo lang("LOGIN"); ?>" 
	 class="btn btn-primary btn-block"
	 name="login" 
	 />
	<!-- End submit field -->
	<a href="admin">Admin Login 🤭</a>
</form>

<!-- End login form -->

<!-- Start singup form -->
<form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" style="<?php if(isset($_POST['signup']))echo 'display: block;'?>">
	
	<!--Start avatar field-->

		 	<span id="custom-button" class="upload-span"><i class="fa fa-upload"></i> Profile Image</span>
			<input type="file" name="avatar" id="real-file" class="form-control" required="required" placeholder="" style="display:none;">
			<?php 
				
				if(isset($_SESSION['errors']['avatar']))
					echo "<label style='color:red'> *". $_SESSION['errors']['avatar'] . " </label>" ;
				unset($_SESSION['errors']['avatar']);
			
				if(isset($_SESSION['errors']['avatar_size']))
					echo "<label style='color:red'> *". $_SESSION['errors']['avatar_size'] . " </label>" ;
				unset($_SESSION['errors']['avatar_size']);
			?>

	<!--End avatar field-->			 
	
	<!-- Start username field -->
	<input
	 pattern=".{3,20}"
	 title="3-20 characters"
	 type="text" 
	 name="username" 
	 autocomplete="off"  
	 class="form-control"
	 placeholder="<?php echo lang("USERNAME"); ?>" 
	 required
	 value="<?php echo isset($_SESSION['old_data']['username']) ? $_SESSION['old_data']['username'] : ''; unset($_SESSION['old_data']['username']); ?>"
	 />
	<?php 
		if(isset($_SESSION['errors']['username']))
			echo "<label style='color:red'> *". $_SESSION['errors']['username'] . " </label>" ;
		unset($_SESSION['errors']['username']);

		if(isset($_SESSION['errors']['user_exist']))
			echo "<label style='color:red'> *". $_SESSION['errors']['user_exist'] . " </label>" ;
		unset($_SESSION['errors']['user_exist']);										 	
	 ?>

	 <!-- End username field -->

	 <!-- Start password field -->
	 <div style="position: relative;">
	<input
	 pattern=".{5,300}"
	 title="5-300 characters"
	 type="password" 
	 name="password" 
	 autocomplete="new-password" 
	 class="form-control password" 
	 placeholder="<?php echo lang("PASSWORD"); ?>"
	 required
	 value="<?php echo isset($_SESSION['old_data']['password']) ? $_SESSION['old_data']['password'] : ''; unset($_SESSION['old_data']['password']); ?>"
	 />
	 <i class="show-pass fa fa-eye fa-2x"></i>
	 <?php 
		if(isset($_SESSION['errors']['password']))
			echo "<label style='color:red'> *". $_SESSION['errors']['password'] . " </label>" ;
		unset($_SESSION['errors']['password']);										 	
	 ?>
	 </div>
	 <!-- End password field -->

	 <!-- Start Repassword field -->
	 <div style="position: relative;">
	 <input
	 pattern=".{5,300}"
	 title="5-300 characters"
	 type="password" 
	 name="repassword" 
	 autocomplete="new-password" 
	 class="form-control password" 
	 placeholder="<?php echo lang("REPASSWORD"); ?>"
	 value="<?php echo isset($_SESSION['old_data']['repassword']) ? $_SESSION['old_data']['repassword'] : ''; unset($_SESSION['old_data']['repassword']); ?>"
	 />
	 <i class="show-pass fa fa-eye fa-2x"></i>
 	 <?php 
	if(isset($_SESSION['errors']['repassword']))
		echo "<label style='color:red'> *". $_SESSION['errors']['repassword'] . " </label>" ;
	unset($_SESSION['errors']['repassword']);										 	
	 ?>	
	</div>
	<!-- End Repassword field -->

	<!-- Start email field -->
	 <input
	 type="email" 
	 name="email" 
	 class="form-control" 
	 placeholder="<?php echo lang("EMAIL"); ?>"
	 required
	 value="<?php echo isset($_SESSION['old_data']['email']) ? $_SESSION['old_data']['email'] : ''; unset($_SESSION['old_data']['email']); ?>"
	 />
 	 <?php 
		if(isset($_SESSION['errors']['email']))
			echo "<label style='color:red'> *". $_SESSION['errors']['email'] . " </label>" ;
		unset($_SESSION['errors']['email']);

		unset($_SESSION['errors']);
		unset($_SESSION['old_data']);
	 ?>
	<!-- End email field -->

	<!-- Start submit field -->
	<input
	 type="submit" 
	 value="<?php echo lang("SIGNUP"); ?>" 
	 class="btn btn-success btn-block" 
	 name="signup"
	 />
	 <!-- End submit field -->
</form>
<!-- End singup form -->


<?php //if user successfully registered
	if(isset($_SESSION['success_reg'])){
		echo "<div class='success_reg text-center'>";			
			echo "<h3>".$_SESSION['success_reg']."</h3>";
		echo "</div>";
	}
	unset($_SESSION['success_reg']);
 ?>


</div>

<script>
//design upload image field
    const realFileBtn=document.getElementById("real-file");
	const customBtn  =document.getElementById("custom-button");
	customBtn.addEventListener("click" , function(){
		realFileBtn.click();
	});
	realFileBtn.addEventListener("change" , function(){
		if(realFileBtn.value){
			customBtn.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
		}
		else
		customBtn.innerHTML = "<i class='fa fa-upload'></i> Profile Image";
	});
</script>


<?php include $tpl .'footer.php';  ob_end_flush(); ?>