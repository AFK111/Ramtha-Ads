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

				$sort = 'ASC';
				$based= 'Ordering';
				$sort_arr= array('ASC','DESC');
				$based_arr=array('Ordering' , 'Name');

				if( isset($_GET['sort']) && in_array($_GET['sort'] , $sort_arr) ){
					$sort = $_GET['sort']; 
				}

				if( isset($_GET['based']) && in_array($_GET['based'] , $based_arr) ){
					$based = $_GET['based']; 
				}				

				$stmt = $con->prepare("SELECT * FROM categories WHERE Parent=0 ORDER BY $based $sort");
				$stmt->execute();
				$categs = $stmt->fetchAll(); ?>

				<h1 class="text-center"> <?php echo lang("MANAGE_CATEGORIES"); ?> </h1>
				<div class="container categories"> <!-- categories class is just to keep track of their children like cat -->

					<div class="panel panel-default">
						<div class="panel-heading">
							 <?php echo lang("MANAGE_CATEGORIES"); ?>
							 <div class='option pull-right'>
							 	<!-- Ordering: -->
							 	[
							 	<a class="<?php if($sort == 'ASC' and $based =='Ordering') echo "active"; ?>" href="?sort=ASC&based=Ordering"> <i class="fa fa-sort-numeric-asc"></i> </a> |
							 	<a class="<?php if($sort == 'DESC' and $based =='Ordering') echo "active"; ?>" href="?sort=DESC&based=Ordering"><i class="fa fa-sort-numeric-desc"></i></a> |
							 	<a class="<?php if($sort == 'ASC' and $based =='Name') echo "active"; ?>" href="?sort=ASC&based=Name"><i class="fa fa-sort-alpha-asc"></i></a> |
							 	<a class="<?php if($sort == 'DESC' and $based =='Name') echo "active"; ?>" href="?sort=DESC&based=Name"><i class="fa fa-sort-alpha-desc"></i></a>
							 	]
							 	<!-- View: -->
							 	[
							 	<span class='active' data-view='full'>Full</span> |
							 	<span>Classic</span>
							 	]
							 </div>	
						</div>
						<div class="panel-body">
								
							<?php 
								
								foreach($categs as $categ)
								{
									echo "<div class='cat'>";

										echo "<div class='hidden-buttons'>";
											echo "<a href='?do=Edit&&catid=".$categ['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> ". lang("EDIT") ."</a>";
											echo "<a href='?do=Delete&catid=".$categ['ID']."' class='btn btn-xs btn-danger confirm'><i class='fa fa-close'></i>" . lang("DELETE") . "</a>";
										echo "</div>";
										
										echo "<h3>".$categ['Name'] . "</h3>";
										echo "<div class='full-view'>";
											echo "<p>".$categ['Description'] . "</p>";
											if($categ['Visibility'] == 1){echo "<span class='visibility'><i class='fa fa-eye-slash'></i> ".lang("HIDDEN")."</span>";}
											if($categ['Allow_Comment'] == 1){echo "<span class='commenting'><i class='fa fa-ban'></i> ".lang("NO_COMMENTING")."</span>";}
											if($categ['Allow_Ads'] == 1){echo "<span class='ads'><i class='fa fa-ban'></i> ".lang("NO_ADS")."</span>";}
										

											//get child categories
											$childCats = getAll("*","categories", "parent = {$categ['ID']}" , "ID" ,"ASC"); 
								           	if(!empty($childCats)){
								           		echo "<h4 class='child-head'>Child categories</h4>";
												echo "<ul class='list-unstyled child-cats'>";
									            foreach($childCats as $c){
									              echo "<li class='child-link'>
									              			<a href='?do=Edit&&catid=".$c['ID']."' >".$c['Name'] . "</a>
									              			<a href='?do=Delete&catid=".$c['ID']."' class='confirm show-delete'>" . lang("DELETE") . "</a>
									              	    </li>";
									            }									
									            echo "</ul>";
											}										
										echo "</div>";	
									echo "</div>";
									


									echo "<hr>";
								}
							 ?>	
						</div>
					</div>					
					<a href="?do=Add" class="btn btn-add"><i class="fa fa-plus"></i> <?php echo lang("ADD_NEW_CATEGORY"); ?></a>
				</div>


<?php 	   }elseif ($do == "Add"){    //Add  Page ?>

		    <h1 class="text-center"><?php echo lang("ADD_NEW_CATEGORY"); ?></h1>

					<div class="container">
						
						<form class="form-horizontal" action="categories.php?do=Insert" method="POST">
							<!--Start Name field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("NAME"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input 
									type="text" 
									name="name" 
									class="form-control" 
									value="<?php echo isset($_SESSION['old_data']['name']) ? $_SESSION['old_data']['name'] : '';  unset($_SESSION['old_data']['name']);  ?>"  
									autocomplete="off" 
									placeholder="<?php echo lang("PLC_HLD_CN"); ?>" 
									required="required">
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

							<!-- Start Parent field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("PARENT"); ?></label>
								<div class="col-sm-10 col-md-4">
									<select name="parent" class="form-control">
										<option <?php if( isset($_SESSION['old_data']['parent'])  && $_SESSION['old_data']['parent']=="0")echo "selected";  ?>  value="0">None</option>
										<?php 
											$cats=getAll("*","categories","Parent=0","ID","ASC");
											foreach($cats AS $cat){
												$sel="";
												if( isset($_SESSION['old_data']['parent'])  && $_SESSION['old_data']['parent']==$cat['ID'] )
													{$sel="selected";}
												echo "<option $sel value='".$cat["ID"]."''>".$cat["Name"]."</option>";
											}
										 ?>
									</select>									
								</div>
							</div>
							<!-- End Parent field -->


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
			
				if($_SERVER['REQUEST_METHOD'] == 'POST'){  //Check if the user move here when he press on save button in the Add page

					echo "<h1 class='text-center'>".lang("INSERT_CATEGORY") ."</h1>";
						
					
					$name 	=$_POST['name'];
					$desc 	=$_POST['description'];
					$parent =$_POST['parent'];
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

						$stmt=$con->prepare("INSERT INTO categories(Name , Description , Parent , Ordering , Visibility, Allow_Comment , Allow_Ads) 
											VALUES(:zname, :zdesc , :zparent , :zorder , :zvisible, :zcomment , :zads)");
						$stmt->execute(array(
							':zname' 	=> $name,
							':zdesc' 	=> $desc,
							':zparent'	=> $parent,
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

					//Check if the get request 'category id' is numeric and get the integer value of it
					
					$catid = ( isset($_GET['catid']) && is_numeric($_GET['catid']) ) ? intval($_GET['catid']) : 0 ;

					//Select all data depend on the $catid

					$stmt = $con->prepare("SELECT * FROM categories WHERE ID=?");        //prepare before enter to DB (safer)
 					$stmt->execute(array($catid));
 					$row=$stmt->fetch();
 					$count=$stmt->rowCount();

 					if($count > 0 && $catid){ ?>
						
 					 <h1 class="text-center"><?php echo lang("EDIT_CATEGORY"); ?></h1>

					<div class="container">
						
						<form class="form-horizontal" action="categories.php?do=Update" method="POST">

							<input type="hidden" name="catid" value="<?php echo $catid; ?>"> <!--to pass private data($catid)-->
							<input type="hidden" name="currname" value="<?php echo $row['Name']; ?>"> <!--to pass private data(category name before editing)-->
							<!--Start Name field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("NAME"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="name" class="form-control" value="<?php echo $row['Name']; ?>" placeholder="<?php echo lang("PLC_HLD_CN"); ?>" required="required">
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
									<input type="text" name="description" value="<?php echo $row['Description'] ?>"  class="form-control"  placeholder="<?php echo lang("PLC_HLD_DC"); ?>" required="required">
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
									<input type="number" name="ordering" value="<?php echo $row['Ordering']; ?>" class="form-control"  placeholder="<?php echo lang("PLC_HLD_SC"); ?>">
									
								</div>
							</div>
							<!--End Ordering field-->

							<!-- Start Parent field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("PARENT"); ?></label>
								<div class="col-sm-10 col-md-4">
									<select name="parent" class="form-control">
										<option <?php if($row['Parent']=="0")echo "selected";  ?> value="0">None</option>
										<?php 
											$cats=getAll("*","categories","Parent=0","ID","ASC");
											foreach($cats AS $cat){

												$sel="";
												if( $row['Parent']==$cat['ID'] )
													{$sel="selected";}
												echo "<option $sel value='".$cat["ID"]."''>".$cat["Name"]."</option>";
											}
										 ?>
									</select>									
								</div>
							</div>
							<!-- End Parent field -->

							<!--Start Visibility field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("VISIBLE"); ?></label>
								<div class="col-sm-10 col-md-4">
									
									<div>
										 <input id="vis-yes" type="radio" name="visibility" value="0" checked>
										 <label for="vis-yes">Yes</label> 
									 </div>

									 <div>
										 <input id="vis-no" type="radio" name="visibility" value="1" <?php if($row['Visibility']==1) echo "checked"; ?>  >
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
										 <input id="com-no" type="radio" name="commenting" value="1" <?php if($row['Allow_Comment']==1) echo "checked"; ?>>
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
										 <input id="ads-no" type="radio" name="ads" value="1" <?php if($row['Allow_Ads']==1) echo "checked"; ?>>
										 <label for="ads-no">No</label> 
									 </div>

								</div>
							</div>
							<!--End Ads field-->	


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

					echo "<h1 class='text-center'>". lang("UPDATE_CATEGORY") ."</h1>";

					//Get the variables from the form
					$id      = $_POST['catid'];
					$cname   = $_POST['name'];
					$desc    = $_POST['description'];
					$parent  = $_POST['parent'];
					$order   = $_POST['ordering'];
					$visible = $_POST['visibility'];
					$comment = $_POST['commenting'];
					$ads     = $_POST['ads'];
					$currname= $_POST['currname'];
					
					//Validate the form

					//Validate the form
					$errors=array();
					//empty category
					if( empty($cname) ){  
						$errors['Cname'] = lang("ERR_CNAME_EMPT");
					}elseif(!preg_match("/^.{3,50}$/", $cname)){
						$errors['Cname'] = lang("ERR_CNAME_LEN");
					}

					//category name exist
					if( checkItem("Name","categories",$cname) && $cname != $currname ){
						$errors['Cexist'] = lang("ERR_CEXIST");
					}	
					//empty description
					if( empty($desc)){
						$errors['description'] = lang("ERR_DESC_EMPT");
					}elseif( !preg_match("/^.{5,100}$/", $desc) ){
						$errors['description'] = lang("ERR_DESC_LEN");
					}

					if(count($errors)>0){   //if there is errors in the Edit form
						$_SESSION['errors']=$errors;
						$catid=$id;
						header("Location: categories.php?do=Edit&catid=$catid");
						exit();
					}
					//Update the database with this information

					
					$stmt = $con -> prepare("UPDATE categories SET Name = ? , Description = ? ,Parent = ?, Ordering = ? , Visibility=? , Allow_Comment=? , Allow_Ads=? WHERE ID = ?");
					$stmt->execute( array($cname,$desc,$parent,$order,$visible,$comment,$ads , $id) );
					
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

			}elseif ($do == "Delete"){  //Delete  page

				echo '<h1 class="text-center">'. lang("DELETE_CATEGORY") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'category id' is numeric and get the integer value of it 
						
						$catid = ( isset($_GET['catid']) && is_numeric($_GET['catid']) ) ? intval($_GET['catid']) : 0 ;

						//check if the category that will be deleted is exist
						
						$check = checkItem("ID" , "categories" , $catid);  
					
	 					if($check > 0 ){

	 						$check=checkItem("Cat_ID","items",$catid);  //to check if the category contain items (to prevent to delete it)
	 						if($check > 0){  //this category contain items
	 								$theMsg= "<div class='alert alert-danger'>".lang("ERR_DEL_C_WITH_I")."</div>";
	 								redirectHome($theMsg , "back" , 10);
	 						}

	 						$stmt = $con->prepare("DELETE FROM categories WHERE ID= :zcategory");
	 						$stmt->bindParam(":zcategory",$catid);
	 						$stmt->execute();

	 						$theMsg = "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '. lang("RECORD_DELETED") .' </div></div>';
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

	ob_end_flush();
 ?>