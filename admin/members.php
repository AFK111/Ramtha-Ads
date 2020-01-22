<?php 
/*
_____________________________
- Manage members page
- You can add | edit | delete | members from here
_____________________________
*/

	session_start();
	$pageTitle="Members";
	if(isset($_SESSION['Username'])){
		
		include "init.php";          //header is here

			$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';    //if the user sent a wrong value with $do so go to main page(manage) 

			if($do=='Manage'){         //Start manage page 


				$post_query = "";
				if(isset($_GET['page']) && $_GET['page']=='Pending')
					$post_query = "AND RegStatus = 0"; 

				//Select all users except admins

				$stmt=$con->prepare("SELECT * FROM users WHERE GroupID != 1 $post_query ORDER BY RegStatus DESC");
				$stmt->execute();	

				//Assign to variable
				$rows=$stmt->fetchAll();
?>

				<h1 class="text-center"> <?php echo lang("MANAGE_MEMBERS"); ?> </h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td> <?php echo lang("#ID"); ?> </td>	
								<td><?php echo lang("USER_NAME"); ?></td>
								<td> <?php echo lang("EMAIL"); ?> </td>
								<td> <?php echo lang("FULL_NAME"); ?> </td>
								<td> <?php echo lang("REGISTERED_DATE"); ?> </td>
								<td> <?php echo lang("CONTROL"); ?> </td>
							</tr>

							<?php 
								
								foreach($rows as $row){
									echo "<tr>";
										echo "<td>" . $row["UserID"] . "</td>";
										echo "<td>" . $row["UserName"] . "</td>";
										echo "<td>" . $row["Email"] . "</td>";
										echo "<td>" . $row["FullName"] . "</td>";
										echo "<td>" . $row["Date"] ."</td>";
										echo "<td>  
												<a href='members.php?do=Edit&userid=" .$row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> ". lang("EDIT") ." </a>
												<a href='members.php?do=Delete&userid=" . $row['UserID'] . " '  class='btn btn-danger confirm'><i class='fa fa-close'></i> ". lang("DELETE") ." </a>";
											
												if($row['RegStatus']==0)
													echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . " '  class='btn btn-info btn-activate'><i class='fa fa-check-square-o' aria-hidden='true'></i> ". lang("ACTIVATE") ." </a>";	

											echo  " </td>";
									echo "</tr>";
								}

							 ?>
						</table>
					</div>
					<a href='members.php?do=Add' class="btn btn-add"><i class="fa fa-plus"></i><?php echo lang("ADD_NEW_MEMBER"); ?> </a>
				</div>	


<?php       }elseif ($do == "Add"){    //Add memberrs Page ?>
				
				<h1 class="text-center"><?php echo lang("ADD_NEW_MEMBER"); ?></h1>

						<div class="container">
							
							<form class="form-horizontal" action="members.php?do=Insert" method="POST">
								<!--Start username field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("USERNAME"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="username" value="<?php echo isset($_SESSION['old_data']['username']) ? $_SESSION['old_data']['username'] : ''; unset($_SESSION['old_data']['username']); ?>" class="form-control"  autocomplete="off" placeholder="" required="required">
										<?php 
											if(isset($_SESSION['errors']['username']))
												echo "<label style='color:red'> *". $_SESSION['errors']['username'] . " </label>" ;
											unset($_SESSION['errors']['username']);

											if(isset($_SESSION['errors']['user_exist']))
												echo "<label style='color:red'> *". $_SESSION['errors']['user_exist'] . " </label>" ;
											unset($_SESSION['errors']['user_exist']);										 	
										 ?>
									</div>
								</div>
								<!--End username field-->



								<!--Start password field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("PASSWORD"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="password" name="password" value="<?php echo isset($_SESSION['old_data']['password']) ? $_SESSION['old_data']['password'] : '';  unset($_SESSION['old_data']['password']);  ?>" class="form-control password" autocomplete="new-password" placeholder="" required="required">
										<i class="show-pass fa fa-eye fa-2x"></i>
										<?php 
											if(isset($_SESSION['errors']['password']))
												echo "<label style='color:red'> *". $_SESSION['errors']['password'] . " </label>" ;
											unset($_SESSION['errors']['password']);
										 ?>
									</div>
								</div>
								<!--End password field-->


								<!--Start repassword field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("REPASSWORD"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="password" name="repassword" value="<?php echo isset($_SESSION['old_data']['repassword']) ? $_SESSION['old_data']['repassword'] : '';  unset($_SESSION['old_data']['repassword']);  ?>" class="form-control password" autocomplete="new-password" placeholder="<?php echo lang("REWRITE PASSWORD"); ?>" required="required">
										
										<?php 
											if(isset($_SESSION['errors']['repassword']))
												echo "<label style='color:red'> *". $_SESSION['errors']['repassword'] . " </label>" ;
											unset($_SESSION['errors']['repassword']);
										 ?>
									</div>
								</div>
								<!--End repassword field-->



								<!--Start email field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("EMAIL"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="email" name="email" value="<?php echo isset($_SESSION['old_data']['email']) ? $_SESSION['old_data']['email'] : '';  unset($_SESSION['old_data']['email']);  ?>" class="form-control" required="required" placeholder="">
										<?php 
											if(isset($_SESSION['errors']['email']))
												echo "<label style='color:red'> *". $_SESSION['errors']['email'] . " </label>" ;
											unset($_SESSION['errors']['email']);
											if(isset($_SESSION['errors']['email_len']))
												echo "<br><label style='color:red'> *". $_SESSION['errors']['email_len'] . " </label>" ;
										 	unset($_SESSION['errors']['email_len']);
										 ?>
									</div>
								</div>
								<!--End email field-->

								<!--Start fullname field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("FULL NAME"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="fullname" value="<?php echo isset($_SESSION['old_data']['fullname']) ? $_SESSION['old_data']['fullname'] : '';  unset($_SESSION['old_data']['fullname']);  ?>" class="form-control" required="required" placeholder="">
										<?php 
											if(isset($_SESSION['errors']['fullname']))
												echo "<label style='color:red'> *". $_SESSION['errors']['fullname'] . " </label>" ;
											unset($_SESSION['errors']['fullname']);
											unset($_SESSION['errors']);
											unset($_SESSION['old_data']);
										 ?>
									</div>
								</div>
								<!--End fullname field-->

								<!--Start submit field-->
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10 col-md-4">
										<input type="submit" value="<?php echo lang("ADD_MEMBER"); ?>" class="btn btn-primary btn-lg" >
									</div>
								</div>
								<!--End submit field-->

							</form>

						</div>


<?php
			}elseif ($do == 'Insert'){  //Insert member page
			
			
				
				if($_SERVER['REQUEST_METHOD'] == 'POST'){  //Check if the user move here when he press on save button in the Add page

					echo "<h1 class='text-center'>".lang("INSERT_MEMBER"). "</h1>";
						
					
					$user=$_POST['username'];
					$pass=$_POST['password'];
					$repass=$_POST['repassword'];
					$email=$_POST['email'];
					$name=$_POST['fullname'];

					$hashpass=sha1($pass);
					


					//Validate the form


					$formErorrs=array();

					if(strlen($user)<3 || strlen($user)>20){
						$formErorrs['username']=lang('ERR_USERNAME');
					}

					if(strlen($name)<3 || strlen($name)>200){
						
						$formErorrs['fullname'] = lang('ERR_FULLNAME');
					}

					if(!preg_match("/^[a-zA-Z][a-zA-Z0-9]+@[a-zA_Z]+\.[a-zA_Z]+$/", $email)){
						$formErorrs['email'] = lang('ERR_EMAIL');
					}
					if(strlen($email)>200){
						$formErorrs['email_len'] = lang('ERR_EMAIL_LEN');	
					}

					if( ($pass != "" && strlen($pass)<5) || strlen($pass)>300){
						$formErorrs['password'] = lang('ERR_PASSWORD');
					}

					if(empty($pass)){
						$formErorrs['password'] = lang('ERR_EMPTY_PASS');	
					}

					if($repass !== $pass){
						$formErorrs['repassword'] = lang('ERR_REPASS');	
					}

					//check if the user name exixst or not
					if(checkItem("UserName","users",$user)){
						$formErorrs['user_exist'] = lang('ERR_USER_EXIST');	
					}
					
					if(count($formErorrs)>0){   //if there is errors in the Edit form
						$_SESSION['errors']=$formErorrs;
						//Get the variables from the form to refill it in the form again
						$_SESSION['old_data']=$_POST;

						header("Location: members.php?do=Add");
						exit();
					}

					


					//Insert into the database that information

						$stmt=$con->prepare("INSERT INTO users(UserName , Password , Email , FullName, GroupID , RegStatus , Date ) 
											VALUES(:zuser, :zpass , :zmail , :zname, 0 , 1 , now())");
						$stmt->execute(array(
							':zuser' => $user,
							':zpass' => $hashpass,
							':zmail' => $email,
							':zname' => $name,
						));
					
					//print success message
					$theMsg = "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '.  lang("RECORD_INSERTED") .'</div></div>';
					redirectHome($theMsg,null,4);


				}else{
					$errMsg= "<div class='alert alert-danger'> ". lang("MSG_ERR_CNT_BROWSE") ." </div>";
					echo "<h1 class='text-center'></h1>";
					echo "<div class='container'>";

					redirectHome($errMsg,"back",4);
					
					echo "</div>";
				}	

			}elseif ($do=='Edit') {	//Edit page  

					//Check if the get request 'user id' is numeric and get the integer value of it
					
					$userid = ( isset($_GET['userid']) && is_numeric($_GET['userid']) ) ? intval($_GET['userid']) : 0 ;

					//Select all data depend on the $userid

					$stmt = $con->prepare("SELECT * FROM users WHERE userid=?");        //prepare before enter to DB (more safe)
 						
					
 					$stmt->execute(array($userid));
 					$row=$stmt->fetch();
 					$count=$stmt->rowCount();

 					if($count > 0 && $userid){
?>
				
						<h1 class="text-center"><?php echo lang("EDIT_MEMBER"); ?></h1>

						<div class="container">
							
							<form class="form-horizontal" action="members.php?do=Update" method="POST">
								<input type="hidden" name="userid" value="<?php echo $userid; ?>"> <!--to pass private data($userid)-->
								<input type="hidden" name="currentname" value="<?php echo $row['UserName'] ?>"> <!--to pass private data($userName)-->
								<!--Start username field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("USERNAME"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="username" class="form-control" value="<?php echo $row['UserName'] ?>" autocomplete="off" placeholder="" required="required">
										<?php 
											if(isset($_SESSION['errors']['username']))
												echo "<label style='color:red'> *". $_SESSION['errors']['username'] . " </label>" ;
											unset($_SESSION['errors']['username']);

											if(isset($_SESSION['errors']['user_exist']))
												echo "<label style='color:red'> *". $_SESSION['errors']['user_exist'] . " </label>" ;
											unset($_SESSION['errors']['user_exist']);
										 ?>
									</div>
								</div>
								<!--End username field-->


								<!--Start current password field-->
								<!-- <div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php //echo lang("PASSWORD"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="password" name="currentpass" class="form-control" autocomplete="new-password" placeholder="<?php //echo lang("CURRENT PASSWORD"); ?>" required="required">
										<?php 
											//if(isset($_SESSION['wp']))
											//	echo "<label style='color:red'> ". lang("WPASSWORD") . " </label>" ;
											//unset($_SESSION['wp']);
										 ?>
									</div>
								</div> -->
								<!--End current password field-->


								<!--Start new password field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("PASSWORD"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
										<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="<?php echo lang("NEW PASSWORD"); ?>">
										<?php 
											if(isset($_SESSION['errors']['password']))
												echo "<label style='color:red'> *". $_SESSION['errors']['password'] . " </label>" ;
											unset($_SESSION['errors']['password']);
										 ?>
									</div>
								</div>
								<!--End new password field-->


								<!--Start email field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("EMAIL"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required">
										<?php 
											if(isset($_SESSION['errors']['email']))
												echo "<label style='color:red'> *". $_SESSION['errors']['email'] . " </label>" ;
											unset($_SESSION['errors']['email']);
											if(isset($_SESSION['errors']['email_len']))
												echo "<br><label style='color:red'> *". $_SESSION['errors']['email_len'] . " </label>" ;
										 	unset($_SESSION['errors']['email_len']);
										 ?>
									</div>
								</div>
								<!--End email field-->

								<!--Start fullname field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("FULL NAME"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName'] ?>" required="required">
										<?php 
											if(isset($_SESSION['errors']['fullname']))
												echo "<label style='color:red'> *". $_SESSION['errors']['fullname'] . " </label>" ;
											unset($_SESSION['errors']['fullname']);
											unset($_SESSION['errors']);
										 ?>
									</div>
								</div>
								<!--End fullname field-->

								<!--Start submit field-->
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10 col-md-4">
										<input type="submit" value="<?php echo lang("SAVE"); ?>" class="btn btn-primary btn-lg" >
									</div>
								</div>
								<!--End submit field-->

							</form>

						</div>

<?php  
				}//if($count > 0 && $userid)
			
				else{ // if such ID is not exist show err message
					 
					$errMsg= "<div class='alert alert-danger'>". lang("MSG_ERR_NO_ID") ."</div>";
					echo "<h1 class='text-center'></h1>"; //to make space between the top of body and the message
					echo "<div class='container'>";

					redirectHome($errMsg,"back",4);
					
					echo "</div>";
				}

			}elseif ($do=='Update'){ //Update page

				
				
				if($_SERVER['REQUEST_METHOD'] == 'POST'){  //Check if the user move here when he press on save button in the Edit page

					echo "<h1 class='text-center'>". lang("UPDATE_MEMBER") ."</h1>";
					//Check if the user Write the current password correct
					// if($_POST['oldpassword'] != sha1($_POST['currentpass']))
					// {
					// 	$_SESSION["wp"]='true';
					// 	$userid=$_SESSION["ID"];
					// 	header("Location: members.php?do=Edit&userid=$userid");
					// 	exit();
						
					// }	


					//Get the variables from the form
					$id=$_POST['userid'];
					$user=$_POST['username'];
					$email=$_POST['email'];
					$name=$_POST['fullname'];
					$currentname=$_POST['currentname'];


					//Password Trick
					
					$pass=empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
					
					//Validate the form


					$formErorrs=array();

					if(strlen($user)<3 || strlen($user)>20){
						$formErorrs['username']=lang('ERR_USERNAME');
					}

					if(strlen($name)<3 || strlen($name)>200){
						
						$formErorrs['fullname'] = lang('ERR_FULLNAME');
					}

					if(!preg_match("/^[a-zA-Z][a-zA-Z0-9]+@[a-zA_Z]+\.[a-zA_Z]+$/", $email)){
						$formErorrs['email'] = lang('ERR_EMAIL');
					}
					if(strlen($email)>200){
						$formErorrs['email_len'] = lang('ERR_EMAIL_LEN');	
					}

					if( ($_POST['newpassword'] != "" && strlen($_POST['newpassword'])<5) || strlen($_POST['newpassword'])>300){
						$formErorrs['password'] = lang('ERR_NPASSWORD');
					}

					//check if the user name exixst or not
					if(checkItem("UserName","users",$user) and $currentname != $user ){
						$formErorrs['user_exist'] = lang('ERR_USER_EXIST');	
					}

					if(count($formErorrs)>0){   //if there is errors in the Edit form
						$_SESSION['errors']=$formErorrs;
						$userid=$id;
						header("Location: members.php?do=Edit&userid=$userid");
						exit();
					}
					//Update the database with this information

					
					$stmt = $con -> prepare("UPDATE users SET UserName = ? , Email = ? , FullName = ? , Password=? WHERE UserID = ?");
					$stmt->execute( array($user,$email,$name,$pass,$id) );
					//$_SESSION['Username']=$user;
					//print success message
					$theMsg= "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '. lang("RECORD_UPDATED") .' </div></div>';
					redirectHome($theMsg,"back",4);


				}else{   
					
					$errMsg= "<div class='alert alert-danger'>". lang("MSG_ERR_CNT_BROWSE") ."</div>";
					echo "<h1 class='text-center'></h1>";
					echo "<div class='container'>";

					redirectHome($errMsg,"back",4);
					
					echo "</div>";
				}


			}elseif ($do == "Delete"){  //Delete member page


					echo '<h1 class="text-center">'. lang("DELETE_MEMBER") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'user id' is numeric and get the integer value of it 
						
						$userid = ( isset($_GET['userid']) && is_numeric($_GET['userid']) ) ? intval($_GET['userid']) : 0 ;

						//check if the user that will be deleted is exist
						
						$check = checkItem("UserID" , "users" , $userid);  
					
	 					if($check > 0 ){

	 						$stmt = $con->prepare("DELETE FROM users WHERE UserID= :zuser");
	 						$stmt->bindParam(":zuser",$userid);
	 						$stmt->execute();

	 						$theMsg = "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '. lang("RECORD_DELETED") .' </div></div>';
	 						redirectHome($theMsg , "back" ,4);

						}else{
							

							$errMsg= "<div class='alert alert-danger'>". lang("MSG_ERR_NO_ID") ."</div>";
							echo "<h1 class='text-center'></h1>";
							echo "<div class='container'>";

							redirectHome($errMsg , null , 4);
					
							echo "</div>";

						}
					echo "</div>";

			}elseif($do == "Activate"){  //Activate member page


					echo '<h1 class="text-center">'. lang("ACTIVATE_MEMBER") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'user id' is numeric and get the integer value of it 
						
						$userid = ( isset($_GET['userid']) && is_numeric($_GET['userid']) ) ? intval($_GET['userid']) : 0 ;

						//check if the user that will be deleted is exist
						
						$check = checkItem("UserID" , "users" , $userid);  
					
	 					if($check > 0 ){

	 						$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID=?");
	 						$stmt->execute( array($userid) );

	 						$theMsg = "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '. lang("RECORD_ACTIVATED") .' </div></div>';
	 						redirectHome($theMsg , "back" ,4);

						}else{
							

							$errMsg= "<div class='alert alert-danger'>".lang("MSG_ERR_NO_ID")."</div>";
							echo "<h1 class='text-center'></h1>";
							echo "<div class='container'>";

							redirectHome($errMsg , null , 4);
					
							echo "</div>";

						}
					echo "</div>";

			}




	 	include $tpl . "footer.php";  //footer file 
	 }
	else{
		header('Location: index.php');
		exit();
	}

 ?>