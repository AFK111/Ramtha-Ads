<?php 
/*
_____________________________

-Categories Page
_____________________________
*/
	
	ob_start();

	session_start();
	$pageTitle="Categories";
	if(isset($_SESSION['Username'])){
		
		include "init.php";          //header is here

			$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';    //if the user sent a wrong value with $do so go to main page(manage) 

			if($do=='Manage'){         //Start manage page 

				$stmt = $con->prepare("SELECT * FROM categories");
				$stmt->execute();
				$categs = $stmt->fetchAll(); ?>

				<h1 class="text-center"> <?php echo lang("MANAGE_CATEGORIES"); ?> </h1>
				<div class="container categories"> <!-- categories class is just to keep track of their children like cat -->

					<div class="panel panel-default">
						<div class="panel-heading"> <?php echo lang("MANAGE_CATEGORIES"); ?> </div>
						<div class="panel-body">
								
							<?php 
								
								foreach($categs as $categ)
								{
									echo "<div class='cat'>";

										echo "<div class='hidden-buttons'>";
											echo "<a href='#' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
											echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
										echo "</div>";


										echo "<h3>".$categ['Name'] . "</h3>";
										echo "<p>".$categ['Description'] . "</p>";
										if($categ['Visibility'] == 1){echo "<span class='visibility'>".lang("HIDDEN")."</span>";}
										if($categ['Allow_Comment'] == 1){echo "<span class='commenting'>".lang("NO_COMMENTING")."</span>";}
										if($categ['Allow_Ads'] == 1){echo "<span class='ads'>".lang("NO_ADS")."</span>";}

									echo "</div>";

									echo "<hr>";
								}


							 ?>	


						</div>
					</div>
					
				</div>


<?php 	   }elseif ($do == "Add"){    //Add  Page ?>

		    <h1 class="text-center"><?php echo lang("ADD_NEW_CATEGORY"); ?></h1>

					<div class="container">
						
						<form class="form-horizontal" action="categories.php?do=Insert" method="POST">
							<!--Start Name field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("NAME"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="name" class="form-control" value="<?php echo isset($_SESSION['old_data']['name']) ? $_SESSION['old_data']['name'] : '';  unset($_SESSION['old_data']['name']);  ?>"  autocomplete="off" placeholder="<?php echo lang("PLC_HLD_CN"); ?>" required="required">
									<?php 
										if(isset($_SESSION['errors']['Cname']))
											echo "<label style='color:red'> *". $_SESSION['errors']['Cname'] . " </label>" ;
										unset($_SESSION['errors']['Cname']);

										if(isset($_SESSION['errors']['Cexist']))
											echo "<label style='color:red'> *". $_SESSION['errors']['Cexist'] . " </label>" ;
										unset($_SESSION['errors']['Cexist']);										 	
									 ?>

								</div>
							</div>
							<!--End Name field-->



							<!--Start Description field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("DESCRIPTION"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="description" value="<?php echo isset($_SESSION['old_data']['description']) ? $_SESSION['old_data']['description'] : '';  unset($_SESSION['old_data']['description']);  ?>"  class="form-control"  placeholder="<?php echo lang("PLC_HLD_DC"); ?>" required="required">
									<?php 
										if(isset($_SESSION['errors']['description']))
											echo "<label style='color:red'> *". $_SESSION['errors']['description'] . " </label>" ;
										unset($_SESSION['errors']['description']);
										
										unset($_SESSION['errors']);
										
									 ?>
								</div>
							</div>
							<!--End Description field-->


							<!--Start Ordering field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("ORDERING"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input type="number" name="ordering" value="<?php echo isset($_SESSION['old_data']['ordering']) ? $_SESSION['old_data']['ordering'] : '';  unset($_SESSION['old_data']['ordering']);  ?>" class="form-control"  placeholder="<?php echo lang("PLC_HLD_SC"); ?>">
									
								</div>
							</div>
							<!--End Ordering field-->

							<!--Start Visibility field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("VISIBLE"); ?></label>
								<div class="col-sm-10 col-md-4">
									
									<div>
										 <input id="vis-yes" type="radio" name="visibility" value="0" Checked>
										 <label for="vis-yes">Yes</label> 
									 </div>

									 <div>
										 <input id="vis-no" type="radio" name="visibility" value="1" <?php if(isset($_SESSION['old_data']['visibility']) and $_SESSION['old_data']['visibility']==1 ) echo "Checked"; unset($_SESSION['old_data']['visibility']);?> >
										 <label for="vis-no">No</label> 
									 </div>

								</div>
							</div>
							<!--End Visibility field-->


							<!--Start Comments field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("ALLOW_COMMENTING"); ?></label>
								<div class="col-sm-10 col-md-4">
									
									<div>
										 <input id="com-yes" type="radio" name="commenting" value="0" Checked>
										 <label for="com-yes">Yes</label> 
									 </div>

									 <div>
										 <input id="com-no" type="radio" name="commenting" value="1" <?php if(isset($_SESSION['old_data']['commenting']) and $_SESSION['old_data']['commenting']==1 ) echo "Checked"; unset($_SESSION['old_data']['commenting']);?>>
										 <label for="com-no">No</label> 
									 </div>

								</div>
							</div>
							<!--End Comments field-->	

							<!--Start Ads field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("ALLOW_ADS"); ?></label>
								<div class="col-sm-10 col-md-4">
									
									<div>
										 <input id="ads-yes" type="radio" name="ads" value="0" Checked>
										 <label for="ads-yes">Yes</label> 
									 </div>

									 <div>
										 <input id="ads-no" type="radio" name="ads" value="1" <?php if(isset($_SESSION['old_data']['ads']) and $_SESSION['old_data']['ads']==1 ) echo "Checked"; unset($_SESSION['old_data']['ads']);?>>
										 <label for="ads-no">No</label> 
									 </div>

								</div>
							</div>
							<!--End Ads field-->	


							<!--Start submit field-->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10 col-md-4">
									<input type="submit" value="<?php echo lang("ADD_CATEGORY"); ?>" class="btn btn-primary btn-lg" >
								</div>
								<?php unset($_SESSION['old_data']); ?>
							</div>
							<!--End submit field-->

						</form>

					</div>

				

		    


		    <?php		
			}elseif ($do == 'Insert'){  //Insert  page
			
				if($_SERVER['REQUEST_METHOD'] == 'POST'){  //Check if the user move here when he press on save button in the Edit page

					echo "<h1 class='text-center'>".lang("INSERT_CATEGORY") ."</h1>";
						
					
					$name 	=$_POST['name'];
					$desc 	=$_POST['description'];
					$order 	=$_POST['ordering'];
					$visible=$_POST['visibility'];
					$comment=$_POST['commenting'];
					$ads   	= $_POST['ads'];
					
					


					//Validate the form
					$errors=array();
					//empty category
					if( empty($name) ){  
						$errors['Cname'] = lang("ERR_CNAME_EMPT");
					}elseif(!preg_match("/^.{3,50}$/", $name)){
						$errors['Cname'] = lang("ERR_CNAME_LEN");
					}

					//category name exist
					if(checkItem("Name","categories",$name)){
						$errors['Cexist'] = lang("ERR_CEXIST");
					}	
					//empty description
					if( empty($desc)){
						$errors['description'] = lang("ERR_DESC_EMPT");
					}elseif( !preg_match("/^.{5,100}$/", $desc) ){
						$errors['description'] = lang("ERR_DESC_LEN");
					}

					
					if(count($errors)>0){   //if there is errors in the form
						$_SESSION['errors']=$errors;
						//Get the variables from the form to refill it in the form again
						$_SESSION['old_data']=$_POST;

						header("Location: categories.php?do=Add");
						exit();
					}

					


					//Insert into the database that information

						$stmt=$con->prepare("INSERT INTO categories(Name , Description , Ordering , Visibility, Allow_Comment , Allow_Ads) 
											VALUES(:zname, :zdesc , :zorder , :zvisible, :zcomment , :zads)");
						$stmt->execute(array(
							':zname' 	=> $name,
							':zdesc' 	=> $desc,
							':zorder'	=> $order,
							':zvisible' => $visible,
							':zcomment' => $comment,
							':zads' 	=> $ads,
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


			}elseif ($do=='Update'){ //Update page


			}elseif ($do == "Delete"){  //Delete  page


			}

	 	include $tpl . "footer.php";  //footer file 
	 }
	else{
		header('Location: index.php');
		exit();
	}

	ob_end_flush();
 ?>