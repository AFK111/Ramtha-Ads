<?php 
/*
_____________________________
- Manage comments page
- You can edit | Delete | Approve comments from here
_____________________________
*/
	ob_start();
	session_start();
	$pageTitle="Comments";
	if(isset($_SESSION['Username'])){
		
		include "init.php";          //header is here

			$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';    //if the user sent a wrong value with $do so go to main page(manage) 

			if($do=='Manage'){         //Start manage page 


				//Select all comments

				$stmt=$con->prepare("SELECT comments.* , items.Name AS IName, users.UserName AS UName
									 FROM comments
									 INNER JOIN items ON items.Item_ID=comments.Item_ID
									 INNER JOIN users ON users.UserID=comments.User_ID");
				$stmt->execute();	

				//Assign to variable
				$rows=$stmt->fetchAll();
?>

				<h1 class="text-center"> <?php echo lang("MANAGE_COMMENTS"); ?> </h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td> <?php echo lang("#ID"); ?> </td>	
								<td><?php echo lang("COMMENTS"); ?></td>
								<td> <?php echo lang("ITEM_NAME"); ?> </td>
								<td> <?php echo lang("USERNAME"); ?> </td>
								<td> <?php echo lang("REGISTERED_DATE"); ?> </td>
								<td> <?php echo lang("CONTROL"); ?> </td>
							</tr>

							<?php 
								
								foreach($rows as $row){
									echo "<tr>";
										echo "<td>" . $row["C_ID"] . "</td>";
										echo "<td>" . $row["Comment"] . "</td>";
										echo "<td>" . $row["IName"] . "</td>";
										echo "<td>" . $row["UName"] . "</td>";
										echo "<td>" . $row["Add_Date"] ."</td>";
										echo "<td>  
												<a href='comments.php?do=Edit&comid=" .$row['C_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> ". lang("EDIT") ." </a>
												<a href='comments.php?do=Delete&comid=" . $row['C_ID'] . " '  class='btn btn-danger confirm'><i class='fa fa-close'></i> ". lang("DELETE") ." </a>";
											
												if($row['Status']==0)
													echo "<a href='comments.php?do=Approve&comid=" . $row['C_ID'] . " '  class='btn btn-info btn-activate'><i class='fa fa-check-square-o' aria-hidden='true'></i> ". lang("APPROVE") ." </a>";	

											echo  " </td>";
									echo "</tr>";
								}

							 ?>
						</table>
					</div>
				</div>	


<?php       }elseif ($do=='Edit') {	//Edit page  

					//Check if the get request 'com id' is numeric and get the integer value of it
					
					$comid = ( isset($_GET['comid']) && is_numeric($_GET['comid']) ) ? intval($_GET['comid']) : 0 ;

					//Select all data depend on the $comid

					$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID=?");        //prepare before enter to DB (more safe)
 					$stmt->execute(array($comid));
 					$row=$stmt->fetch();
 					$count=$stmt->rowCount();

 					if($count > 0 && $comid){
?>
				
						<h1 class="text-center"><?php echo lang("EDIT_COMMENT"); ?></h1>

						<div class="container">
							
							<form class="form-horizontal" action="comments.php?do=Update" method="POST">
								<input type="hidden" name="comid" value="<?php echo $comid; ?>"> <!--to pass private data($comid)-->
								<!--Start comment field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("COMMENT"); ?></label>
									<div class="col-md-4 col-sm-10">	
										<textarea class="form-control" name='comment' required><?php echo $row['Comment']; ?></textarea>		
										<?php 
											if(isset($_SESSION['errors']['comment']))
												echo "<label style='color:red'> *". $_SESSION['errors']['comment'] . " </label>" ;
											unset($_SESSION['errors']['comment']);
											?>
									</div>
								</div>
								<!--End comment field-->


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

					echo "<h1 class='text-center'>". lang("UPDATE_COMMENT") ."</h1>";


					//Get the variables from the form
					$id=$_POST['comid'];
					$comment=$_POST['comment'];
		
					//Validate the form


					$formErorrs=array();

					if(strlen($comment)==0 ){
						$formErorrs['comment']=lang('EMP_COMMENT');
					}

					
					if(count($formErorrs)>0){   //if there is errors in the Edit form
						$_SESSION['errors']=$formErorrs;
						header("Location: comments.php?do=Edit&comid=$id");
						exit();
					}
					//Update the database with this information

					
					$stmt = $con -> prepare("UPDATE comments SET Comment = ? WHERE C_ID = ?");
					$stmt->execute(array($comment,$id));
					
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


					echo '<h1 class="text-center">'. lang("DELETE_COMMENT") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'comid' is numeric and get the integer value of it 
						
						$comid = ( isset($_GET['comid']) && is_numeric($_GET['comid']) ) ? intval($_GET['comid']) : 0 ;

						//check if the user that will be deleted is exist
						
						$check = checkItem("C_ID" , "comments" , $comid);  
					
	 					if($check > 0 ){

	 						$stmt = $con->prepare("DELETE FROM comments WHERE C_ID= :zcom");
	 						$stmt->bindParam(":zcom",$comid);
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

			}elseif($do == "Approve"){  //Activate member page


					echo '<h1 class="text-center">'. lang("APPROVE_COMMENT") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'com id' is numeric and get the integer value of it 
						
						$comid = ( isset($_GET['comid']) && is_numeric($_GET['comid']) ) ? intval($_GET['comid']) : 0 ;

						//check if the comment that will be deleted is exist
						
						$check = checkItem("C_ID" , "comments" , $comid);  
					
	 					if($check > 0 ){

	 						$stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID=?");
	 						$stmt->execute( array($comid) );

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

			}elseif( $do =="Show" ){  //show comments accroding to the item id

				echo '<div class="container">';

						//Check if the get request 'item id' is numeric and get the integer value of it 
						
						$itemid = ( isset($_GET['itemid']) && is_numeric($_GET['itemid']) ) ? intval($_GET['itemid']) : 0 ;

						//check if the item exist or not
						$check = checkItem("Item_ID" , "items" , $itemid);  
					
	 					if($check > 0 ){//if the item exist to show thier comments


	 						//get items information
							$stmt = $con->prepare("SELECT Name,Price,Currency FROM items where Item_ID=?");
		 					$stmt->execute(array($itemid));
		 					$Irow=$stmt->fetchAll();
		 					
		 					?>
		 					<h1 class="text-center"><?php echo $Irow[0]['Name']; ?>'s comments</h1>
		 					<div class="card" style="width: 28rem; ">
							  <img class="card-img-top" src="layout/images/noImage.png" alt="Card image cap">
							  <div class="card-body">
							    <h5 class="card-title"><?php echo $Irow[0]['Name']; ?></h5>
							    <p class="card-text"> <?php echo $Irow[0]['Price']." ".$Irow[0]['Currency']; ?> </p>
							    
							  </div>
							</div>
	
		 					<?php
	 						//Check if there are comments for the item
	 						$check=checkItem("Item_ID" , "comments" , $itemid);
	 						if($check > 0){
		 						//get the comments of this item
		 						$stmt = $con->prepare("SELECT comments.* , users.UserName AS UName
		 											   FROM comments
		 											   INNER JOIN users ON users.UserID=comments.User_ID 
		 											   WHERE comments.Item_ID=?;");
		 						$stmt->execute(array($itemid));
		 						$rows=$stmt->fetchAll(); ?>
					    <?php   
					    		foreach($rows as $row){ ?>
		 							
		 							<div class="col-md-7 col-sm-10 col-xs-12">
			 							<div class="panel panel-danger panel-comment">
											<div class="panel-heading">
												<i class="fa fa-user" style="color:#3437BC;"></i>
												<?php echo $row['UName']; ?>
												<span class="toggle-info pull-right">
													<i class="fa fa-minus fa-lg"></i>
												</span>
												
											</div>
											<div class="panel-body panel-body-comment">
												<div class="button-comment btn-group">
													<a href="?do=Edit&comid=<?php echo $row['C_ID']; ?>" class='btn btn-success btn-xs'><?php echo lang("EDIT"); ?></a>
													<a href="?do=Delete&comid=<?php echo $row['C_ID']; ?>" class=" confirm btn btn-danger btn-xs"><?php echo lang("DELETE"); ?></a>
													<?php if($row['Status']==0) 
														echo "<a href='?do=Approve&comid=".$row['C_ID']."' class='btn btn-info btn-ap btn-xs'>".lang("APPROVE")."</a>";
													?>
												</div>
												<?php echo "<h4>".$row['Comment']."</h4>"; ?>
											</div>
										</div>	
									</div>	
		 				  <?php }

		 					}else{
		 						echo "<h3 class=''>".lang("NO_COMMENT")."</h3>";
		 					}	
	 						

						}else{
							

							$errMsg= "<div class='alert alert-danger'>". lang("MSG_ERR_NO_ID") ."</div>";
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

	ob_end_flush();
 ?>