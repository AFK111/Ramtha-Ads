<?php 
/*
_____________________________

-Items Page
_____________________________
*/
	
	ob_start();

	session_start();
	$pageTitle="Items";
	if(isset($_SESSION['Username'])){
		
		include "init.php";          //header is here

			$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';    //if the user sent a wrong value with $do so go to main page(manage) 

			if($do=='Manage'){         //Start manage page 

					

				//Select all items 

				$stmt=$con->prepare("SELECT items.*,categories.Name AS cname,users.UserName AS uname									
									FROM items										
									INNER JOIN categories ON categories.ID = items.Cat_ID
									INNER JOIN users ON users.UserID = items.Member_ID
									ORDER BY items.Approve DESC");
				$stmt->execute();	
			
				//Assign to variable
				$items=$stmt->fetchAll(); ?>

				<h1 class="text-center"> <?php echo lang("MANAGE_ITEMS"); ?> </h1>

				<div class="pull-right view-item-btn">
					<a href="?do=Manage" class="btn btn-info"><i class="fa fa-table"></i> Table</a>
					<a href="?view=cards" class="btn btn-info small"><i class="fa fa-id-card-o"></i> Cards</a>	
				</div>
				<?php 
				if( isset($_GET['view']) && $_GET['view']=='cards'){
							
						echo "<div class='container'>";	

						foreach($items as $item){?>

							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">		
								<div class="card" style="width: 28rem; ">
									<div class="card-header"><?php echo $item['cname']; ?></div>
								  <img class="card-img-top" src="layout/images/noImage.png" alt="Card image cap">
								  <div class="card-body">
								    <h3 class="card-title"><?php echo $item['Name']; ?></h3>
								    <p class="card-text"><?php echo $item['Price'] ." ",$item['Currency']; ?></p>
								    <a href='comments.php?do=Show&itemid=<?php echo $item['Item_ID']?>' class='btn btn-primary'><i class='fa fa-comment'></i> <?php echo lang("SHOW_COMMENTS") ?> </a>
								  </div>
								</div>
							</div>	

              	<?php    }
              		echo "</div>";
				}
				else {
?>

				
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td> <?php echo lang("#ID"); ?> </td>	
								<td><?php echo lang("NAME"); ?></td>
								<td> <?php echo lang("DESCRIPTION"); ?> </td>
								<td> <?php echo lang("PRICE"); ?> </td>
								<td> <?php echo lang("ADDED_BY"); ?> </td>
								<td> <?php echo lang("CATEGORY"); ?> </td>
								<td> <?php echo lang("REGISTERED_DATE"); ?> </td>
								<td> <?php echo lang("CONTROL"); ?> </td>
							</tr>

							<?php 
								
								foreach($items as $item){
									echo "<tr>";
										echo "<td>" . $item["Item_ID"] . "<a href='comments.php?do=Show&itemid=".$item['Item_ID']."'><i class='fa fa-comment'></i></a></td>";
										echo "<td>" . $item["Name"] . "</td>";
										echo "<td>" . $item["Description"] . "</td>";
										echo "<td>" . $item["Price"] ." ". $item["Currency"] . "</td>";
										echo "<td>" . $item["uname"] ."</td>";
										echo "<td>" . $item["cname"] ."</td>";
										echo "<td>" . $item["Add_Date"] ."</td>";

										echo "<td>  
												<a href='items.php?do=Edit&itemid=" .$item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> ". lang("EDIT") ." </a>
												<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . " '  class='btn btn-danger confirm'><i class='fa fa-close'></i> ". lang("DELETE") ." </a>";
											
												if($item['Approve'] == 0)
													echo "<a href='items.php?do=Approve&itemid=". $item['Item_ID']."' class='btn btn-info btn-activate'><i class='fa fa-check-square-o'></i> ". lang("APPROVE")."</a>";

											echo  " </td>";
									echo "</tr>";
								}

							 ?>
						</table>
					</div>
					<a href='?do=Add' class='btn btn-add'><i class='fa fa-plus'></i> <?php   echo lang("ADD_NEW_ITEM"); ?> </a>	
				</div>
				

		<?php }  }elseif ($do == "Add"){    //Add  Page ?>
				
				<h1 class="text-center"><?php echo lang("ADD_NEW_ITEM"); ?></h1>

					<div class="container">
						
						<form class="form-horizontal" action="items.php?do=Insert" method="POST">
							<!--Start Name field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("NAME"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input 
									type="text" 
									name="name" 
									class="form-control" 
									value="<?php echo isset($_SESSION['old_data']['name']) ? $_SESSION['old_data']['name'] : '';  unset($_SESSION['old_data']['name']);  ?>" 
									placeholder="<?php echo lang("PLC_HLD_IN"); ?>" 
									required="required" />
									
									<?php 
										if(isset($_SESSION['errors']['name_len']))
											echo "<label style='color:red'> *". $_SESSION['errors']['name_len'] . " </label>" ;
										unset($_SESSION['errors']['name_len']);

										if(isset($_SESSION['errors']['name_f']))
											echo "<label style='color:red'> *". $_SESSION['errors']['name_f'] . " </label>" ;
										unset($_SESSION['errors']['name_f']);										 	
									 ?>

								</div>
							</div>
							<!--End Name field-->

							<!--Start Description field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("DESCRIPTION"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input
									 type="text" 
									 name="description" 
									 class="form-control" 
									 value="<?php echo isset($_SESSION['old_data']['description']) ? $_SESSION['old_data']['description'] : '';  unset($_SESSION['old_data']['description']);  ?>" 
									 placeholder="<?php echo lang("PLC_HLD_DI"); ?>" 
									 required="required" />
									
									<?php 
										if(isset($_SESSION['errors']['description']))
											echo "<label style='color:red'> *". $_SESSION['errors']['description'] . " </label>" ;
										unset($_SESSION['errors']['description']); 	
									 ?>	

								</div>
							</div>
							<!--End Description field-->


							<!--Start Price field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("PRICE"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input
									 type="text" 
									 name="price" 
									 class="form-control" 
									 value="<?php echo isset($_SESSION['old_data']['price']) ? $_SESSION['old_data']['price'] : '';  unset($_SESSION['old_data']['price']);  ?>" 
									 placeholder="<?php echo lang("PLC_HLD_IP"); ?>" 
									 required="required" />
									 <select name='currency' class="">
									 	<option <?php if( isset($_SESSION['old_data']['currency'])  && $_SESSION['old_data']['currency']=="0")echo "selected"; ?> value="0"; >....</option>
									 	<option <?php if( isset($_SESSION['old_data']['currency'])  && $_SESSION['old_data']['currency']=="US dollar")echo "selected";  ?> > <?php echo lang("US_DOLLAR"); ?></option>
									 	<option <?php if( isset($_SESSION['old_data']['currency'])  && $_SESSION['old_data']['currency']=="JD")echo "selected";  ?> ><?php echo lang("JD"); ?></option>
									 </select>
									 <?php 
										if(isset($_SESSION['errors']['price']))
											echo "<label style='color:red'> *". $_SESSION['errors']['price'] . " </label>" ;
										unset($_SESSION['errors']['price']); 	
										
										if(isset($_SESSION['errors']['currency']))
											echo "<label style='color:red'> *". $_SESSION['errors']['currency'] . " </label>" ;
										unset($_SESSION['errors']['currency']); 	
									 									 

									 ?>
								</div>
							</div>
							<!--End Price field-->


							<!--Start Production_Country field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label"><?php echo lang("COUNTRY"); ?></label>
								<div class="col-sm-10 col-md-4">
									<input
									 type="text" 
									 name="country" 
									 class="form-control" 
									 value="<?php echo isset($_SESSION['old_data']['country']) ? $_SESSION['old_data']['country'] : '';  unset($_SESSION['old_data']['country']);  ?>" 
									 placeholder="<?php echo lang("PLC_HLD_PC"); ?>" /> 
									  
								</div>
							</div>
							<!--End Production_Country field-->


							<!--Start Status field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-xs-8 control-label"><?php echo lang("STATUS"); ?></label>
								<div class="col-sm-10 col-md-4 col-xs-5">
									<select name="status" class="form-control">

										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="0")echo "selected";  ?> value="0">.....</option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="1")echo "selected";  ?> value="1"><?php echo lang("NEW"); ?></option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="2")echo "selected";  ?> value="2"><?php echo lang("ALMOST_NEW"); ?></option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="3")echo "selected";  ?> value="3"><?php echo lang("USED"); ?></option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="4")echo "selected";  ?> value="4"><?php echo lang("NEED_TO_FIX"); ?></option>
									</select>
									<?php 
										if(isset($_SESSION['errors']['status']))
											echo "<label style='color:red'> *". $_SESSION['errors']['status'] . " </label>" ;
										unset($_SESSION['errors']['status']); 	
									 ?>
								</div>
							</div>
							<!--End Status field-->

							
							<!--Start Members field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-xs-8 control-label"><?php echo lang("MEMBER"); ?></label>
								<div class="col-sm-10 col-md-4 col-xs-5">
									<select name="member" class="form-control">

										<option <?php if( isset($_SESSION['old_data']['member'])  && $_SESSION['old_data']['member']=="0")echo "selected";  ?> value="0">.....</option>
										<?php 

											$stmt=$con->prepare("SELECT * FROM users WHERE RegStatus=1");
											$stmt->execute();
											$users=$stmt->fetchAll();
											foreach($users as $user)
											{
												$sel="";
												if( isset($_SESSION['old_data']['member'])  && $_SESSION['old_data']['member']==$user['UserID'] )
													{$sel="selected";}
												echo "<option $sel value='".$user['UserID']."'>".$user['UserName']."</option>";
											}

										 ?>

									</select>
									<?php 
										if(isset($_SESSION['errors']['member']))
											echo "<label style='color:red'> *". $_SESSION['errors']['member'] . " </label>" ;
										unset($_SESSION['errors']['member']); 	
									 ?>
								</div>
							</div>
							<!--End Members field-->

							<!--Start categories field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-xs-8 control-label"><?php echo lang("CATEGORY"); ?></label>
								<div class="col-sm-10 col-md-4 col-xs-5">
									<select name="category" class="form-control">

										<option <?php if( isset($_SESSION['old_data']['category'])  && $_SESSION['old_data']['category']=="0")echo "selected";  ?> value="0">.....</option>
										<?php 

											$stmt=$con->prepare("SELECT * FROM categories");
											$stmt->execute();
											$categs=$stmt->fetchAll();
											foreach($categs as $category)
											{
												$sel="";
												if( isset($_SESSION['old_data']['category'])  && $_SESSION['old_data']['category']==$category['ID'] )
													{$sel="selected";}
												echo "<option $sel value='".$category['ID']."'>".$category['Name']."</option>";
											}

										 ?>

									</select>
									<?php 
										if(isset($_SESSION['errors']['category']))
											echo "<label style='color:red'> *". $_SESSION['errors']['category'] . " </label>" ;
										unset($_SESSION['errors']['category']); 	
									 ?>
								</div>
							</div>
							<!--End categories field-->



							<!--Start submit field-->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10 col-md-4">
									<input type="submit" value="<?php echo lang("ADD_ITEM"); ?>" class="btn btn-primary btn-lg" >
								</div>
								<?php 
									unset($_SESSION['errors']);
									unset($_SESSION['old_data']);

								 ?>
							</div>
							<!--End submit field-->

						</form>

					</div>	

		    <?php
			}elseif ($do == 'Insert'){  //Insert  page
					
				if($_SERVER['REQUEST_METHOD'] == 'POST'){  //Check if the user move here when he press on save button in the Add page

					echo "<h1 class='text-center'>".lang("INSERT_ITEM"). "</h1>";
						
					
					$iname	 =$_POST['name'];
					$desc    =$_POST['description'];
					$price   =$_POST['price'];
					$currency=$_POST['currency'];
					$country =$_POST['country'];
					$status  =$_POST['status'];
					$member  =$_POST['member'];
					$category=$_POST['category'];


					//Validate the form


					$formErorrs=array();

					//iname validation
					if( strlen($iname)<2 || strlen($iname)>14 )
						$formErorrs['name_len'] = lang("ERR_LEN_INAME");
					elseif( !preg_match('/^[a-zA-Z][a-zA-Z0-9\W]+$/', $iname) )
						$formErorrs['name_f'] = lang("ERR_FORMAT_INAME");		

					//description validation
					if( strlen($desc)<10 || strlen($desc)>200 )
						$formErorrs['description'] = lang("ERR_LEN_DESCRIPTION");

					//price validation
					if(empty($price))
						$formErorrs['price'] = lang("ERR_EMP_PRICE");
					elseif( !preg_match('/^[0-9]{0,10}(\.[0-9]{1,2})?$/', $price) )
						$formErorrs['price'] = lang("ERR_FORMAT_PRICE");

					//currency validation
					if($currency === "0")
						$formErorrs['currency'] = lang("ERR_EMP_CURRENCY");
					//country validation:later I will make it listbox
					
					//status validation
					if($status === "0")
						$formErorrs['status'] = lang("ERR_EMP_STATUS");

					//member validation
					if($member==="0")
						$formErorrs['member'] = lang("ERR_EMP_MEMBER");

					//category validation
					if($category==="0")
						$formErorrs['category'] = lang("ERR_EMP_CATEGORY");						

					//if there is errors in the Edit form
					if(count($formErorrs)>0){   
						$_SESSION['errors']=$formErorrs;
						//Get the variables from the form to refill it in the form again
						$_SESSION['old_data']=$_POST;

						header("Location: items.php?do=Add");
						exit();
					}

					


					//Insert into the database that information

						$stmt=$con->prepare("INSERT INTO items(Name , Description , Price , Add_Date, Production_Country ,Status,Currency,Member_ID,Cat_ID) 
											VALUES(:iname, :idesc , :iprice , now(), :pcountry , :istatus,:currency,:Member_ID,:Cat_ID)");
						$stmt->execute(array(
							'iname'    => $iname,
							'idesc'    => $desc,
							'iprice'   => $price,
							'pcountry' => $country,
							'istatus'  => $status,
							'currency' =>$currency,
							'Member_ID'=>$member,
							'Cat_ID'	=>$category,
						));
					//unset($_SESSION['old_data']);
					//print success message
					$theMsg = "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '.  lang("RECORD_INSERTED") .'</div></div>';
					redirectHome($theMsg,"items.php?do=Add",4);


				}else{
					$errMsg= "<div class='alert alert-danger'> ". lang("MSG_ERR_CNT_BROWSE") ." </div>";
					echo "<h1 class='text-center'></h1>";
					echo "<div class='container'>";

					redirectHome($errMsg,"back",4);
					
					echo "</div>";
				}	


			}elseif ($do=='Edit') {	//Edit page  


				//Check if the get request 'item id' is numeric and get the integer value of it
					
					$itemid = ( isset($_GET['itemid']) && is_numeric($_GET['itemid']) ) ? intval($_GET['itemid']) : 0 ;

					//Select all data depend on the $userid

					$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID=?");        //prepare before enter to DB (more safe)
 						
					
 					$stmt->execute(array($itemid));
 					$item=$stmt->fetch();
 					$count=$stmt->rowCount();

 					if($count > 0 && $itemid){ ?>
				

 						<h1 class="text-center"><?php echo lang("EDIT_ITEM"); ?></h1>

						<div class="container">
							
							<form class="form-horizontal" action="items.php?do=Update" method="POST">
								<input type="hidden" name="itemid" value="<?php echo $item['Item_ID']; ?>"> <!--to pass private data($itemid)-->	
								<!--Start Name field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("NAME"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input 
										type="text" 
										name="name" 
										class="form-control" 
										value="<?php echo $item['Name'];  ?>" 
										placeholder="<?php echo lang("PLC_HLD_IN"); ?>" 
										required="required" />
										
										<?php 
											if(isset($_SESSION['errors']['name_len']))
												echo "<label style='color:red'> *". $_SESSION['errors']['name_len'] . " </label>" ;
											unset($_SESSION['errors']['name_len']);

											if(isset($_SESSION['errors']['name_f']))
												echo "<label style='color:red'> *". $_SESSION['errors']['name_f'] . " </label>" ;
											unset($_SESSION['errors']['name_f']);										 	
										 ?>

									</div>
								</div>
								<!--End Name field-->

								<!--Start Description field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("DESCRIPTION"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input
										 type="text" 
										 name="description" 
										 class="form-control" 
										 value="<?php echo $item['Description'];  ?>" 
										 placeholder="<?php echo lang("PLC_HLD_DI"); ?>" 
										 required="required" />
										
										<?php 
											if(isset($_SESSION['errors']['description']))
												echo "<label style='color:red'> *". $_SESSION['errors']['description'] . " </label>" ;
											unset($_SESSION['errors']['description']); 	
										 ?>	

									</div>
								</div>
								<!--End Description field-->


								<!--Start Price field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("PRICE"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input
										 type="text" 
										 name="price" 
										 class="form-control" 
										 value="<?php echo $item['Price']; ?>" 
										 placeholder="<?php echo lang("PLC_HLD_IP"); ?>" 
										 required="required" />
										 <select name='currency' class="">

										 	<option <?php if($item['Currency'] == "US dollar")echo "selected";  ?> > <?php echo lang("US_DOLLAR"); ?></option>
										 	<option <?php if($item['Currency'] == "JD")echo "selected";  ?> ><?php echo lang("JD"); ?></option>
										 </select>
										 <?php 
											if(isset($_SESSION['errors']['price']))
												echo "<label style='color:red'> *". $_SESSION['errors']['price'] . " </label>" ;
											unset($_SESSION['errors']['price']); 	
											
										 ?>
									</div>
								</div>
								<!--End Price field-->


								<!--Start Production_Country field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label"><?php echo lang("COUNTRY"); ?></label>
									<div class="col-sm-10 col-md-4">
										<input
										 type="text" 
										 name="country" 
										 class="form-control" 
										 value="<?php echo $item['Production_Country'];  ?>" 
										 placeholder="<?php echo lang("PLC_HLD_PC"); ?>" /> 
										  
									</div>
								</div>
								<!--End Production_Country field-->


								<!--Start Status field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 col-xs-8 control-label"><?php echo lang("STATUS"); ?></label>
									<div class="col-sm-10 col-md-4 col-xs-5">
										<select name="status" class="form-control">

											<option <?php if($item['Status']=="1")echo "selected";  ?> value="1"><?php echo lang("NEW"); ?></option>
											<option <?php if($item['Status']=="2")echo "selected";  ?> value="2"><?php echo lang("ALMOST_NEW"); ?></option>
											<option <?php if($item['Status']=="3")echo "selected";  ?> value="3"><?php echo lang("USED"); ?></option>
											<option <?php if($item['Status']=="4")echo "selected";  ?> value="4"><?php echo lang("NEED_TO_FIX"); ?></option>
										</select>
										
									</div>
								</div>
								<!--End Status field-->

								
								<!--Start Members field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 col-xs-8 control-label"><?php echo lang("MEMBER"); ?></label>
									<div class="col-sm-10 col-md-4 col-xs-5">
										<select name="member" class="form-control">

											<?php 

												$stmt=$con->prepare("SELECT * FROM users");
												$stmt->execute();
												$users=$stmt->fetchAll();
												foreach($users as $user)
												{
													$sel="";
													if( $item['Member_ID']==$user['UserID'] )
														{$sel="selected";}
													echo "<option $sel value='".$user['UserID']."'>".$user['UserName']."</option>";
												}

											 ?>

										</select>
										
									</div>
								</div>
								<!--End Members field-->

								<!--Start categories field-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 col-xs-8 control-label"><?php echo lang("CATEGORY"); ?></label>
									<div class="col-sm-10 col-md-4 col-xs-5">
										<select name="category" class="form-control">

											<?php 

												$stmt=$con->prepare("SELECT * FROM categories");
												$stmt->execute();
												$categs=$stmt->fetchAll();
												foreach($categs as $category)
												{
													$sel="";
													if( $item['Cat_ID']==$category['ID'] )
														{$sel="selected";}
													echo "<option $sel value='".$category['ID']."'>".$category['Name']."</option>";
												}

											 ?>

										</select>
										
									</div>
								</div>
								<!--End categories field-->



								<!--Start submit field-->
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10 col-md-4">
										<input type="submit" value="<?php echo lang("SAVE"); ?>" class="btn btn-primary btn-lg" >
									</div>
									<?php 
										unset($_SESSION['errors']);
									 ?>
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

					echo "<h1 class='text-center'>".lang("UPDATE_ITEM"). "</h1>";
						
						
					$iname	 =$_POST['name'];
					$desc    =$_POST['description'];
					$price   =$_POST['price'];
					$currency=$_POST['currency'];
					$country =$_POST['country'];
					$status  =$_POST['status'];
					$member  =$_POST['member'];
					$category=$_POST['category'];

					$itemid=$_POST['itemid'];




					//Validate the form


					$formErorrs=array();

					//iname validation
					if( strlen($iname)<2 || strlen($iname)>14 )
						$formErorrs['name_len'] = lang("ERR_LEN_INAME");
					elseif( !preg_match('/^[a-zA-Z][a-zA-Z0-9\W]+$/', $iname) )
						$formErorrs['name_f'] = lang("ERR_FORMAT_INAME");		

					//description validation
					if( strlen($desc)<10 || strlen($desc)>200 )
						$formErorrs['description'] = lang("ERR_LEN_DESCRIPTION");

					//price validation
					if(empty($price))
						$formErorrs['price'] = lang("ERR_EMP_PRICE");
					elseif( !preg_match('/^[0-9]{0,10}(\.[0-9]{1,2})?$/', $price) )
						$formErorrs['price'] = lang("ERR_FORMAT_PRICE");

					//country validation:later I will make it listbox
						

					//if there is errors in the Edit form
					if(count($formErorrs)>0){   
						$_SESSION['errors']=$formErorrs;
						//Get the variables from the form to refill it in the form again
						header("Location: items.php?do=Edit&itemid=$itemid");
						exit();
					}

					


					//Update the database with this information

						$stmt = $con -> prepare("UPDATE items SET Name = ? , Description = ? , Price = ? , Production_Country=? ,Status=?, Currency=?,
												                  Member_ID=?, Cat_ID=?	 WHERE Item_ID = ?");			
						$stmt->execute(array($iname ,$desc , $price ,$country ,$status ,$currency ,$member ,$category,$itemid));
			
					//print success message
					$theMsg= "<div class='container'><div class='alert alert-success'>" . $stmt->rowCount() .' '. lang("RECORD_UPDATED") .' </div></div>';
					redirectHome($theMsg,"back",4);


				}else{
					$errMsg= "<div class='alert alert-danger'> ". lang("MSG_ERR_CNT_BROWSE") ." </div>";
					echo "<h1 class='text-center'></h1>";
					echo "<div class='container'>";

					redirectHome($errMsg,"back",4);
					
					echo "</div>";
				}

			}elseif ($do == "Delete"){  //Delete  page

				echo '<h1 class="text-center">'. lang("DELETE_ITEM") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'item id' is numeric and get the integer value of it 
						
						$itemid = ( isset($_GET['itemid']) && is_numeric($_GET['itemid']) ) ? intval($_GET['itemid']) : 0 ;

						//check if the item that will be deleted is exist
						
						$check = checkItem("Item_ID" , "items" , $itemid);  
					
	 					if($check > 0 ){

	 						$stmt = $con->prepare("DELETE FROM items WHERE Item_ID= :zitem");
	 						$stmt->bindParam(":zitem",$itemid);
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

			}elseif($do == "Approve"){  //Approve  page

				echo '<h1 class="text-center">'. lang("APPROVE_ITEM") .'</h1>';

					echo '<div class="container">';

						//Check if the get request 'item id' is numeric and get the integer value of it 
						
						$itemid = ( isset($_GET['itemid']) && is_numeric($_GET['itemid']) ) ? intval($_GET['itemid']) : 0 ;

						//check if the user that will be deleted is exist
						
						$check = checkItem("Item_ID" , "items" , $itemid);  
					
	 					if($check > 0 ){

	 						$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID=?");
	 						$stmt->execute( array($itemid) );

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

	ob_end_flush();
 ?>