<?php
	ob_start();
	session_start();
 	$pageTitle="Create New Ad";
 	include "init.php"; 

 	if(isset($_SESSION['user'])){


 		if($_SERVER['REQUEST_METHOD'] == 'POST'){

 			$iname	 =filter_var($_POST['name'] , FILTER_SANITIZE_STRING);
			$desc    =filter_var($_POST['description'] , FILTER_SANITIZE_STRING);
			$price   =$_POST['price'];
			$currency=filter_var($_POST['currency'] , FILTER_SANITIZE_STRING);
			$country =filter_var($_POST['country'] , FILTER_SANITIZE_STRING);
			$status  =filter_var($_POST['status'] , FILTER_SANITIZE_NUMBER_INT);
			$category=filter_var($_POST['category'] , FILTER_SANITIZE_NUMBER_INT);
			$tags    =filter_var($_POST['tags'] , FILTER_SANITIZE_STRING);

			$memberid=$_SESSION['userid'];  //the member who insert the item
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
	
			//category validation
			if($category==="0")
				$formErorrs['category'] = lang("ERR_EMP_CATEGORY");						

			//if there is errors in the Edit form
			if(count($formErorrs)>0){   
				$_SESSION['errors']=$formErorrs;
				//Get the variables from the form to refill it in the form again
				$_SESSION['old_data']=$_POST;
			}else{ //if there are no error

				//Insert into the database that information

				$stmt=$con->prepare("INSERT INTO items(Name , Description , Price , Add_Date, Production_Country ,Status,Currency,Member_ID,Cat_ID,Tags) 
									VALUES(:iname, :idesc , :iprice , now(), :pcountry , :istatus,:currency,:Member_ID,:Cat_ID,:tags)");
				$stmt->execute(array(
					'iname'    => $iname,
					'idesc'    => $desc,
					'iprice'   => $price,
					'pcountry' => $country,
					'istatus'  => $status,
					'currency' =>$currency,
					'Member_ID'=>$memberid,
					'Cat_ID'   =>$category,
					'tags'	   =>$tags,	
				));
				if($stmt){
					header("Location: newad.php?success=1");
					exit();
				}
				
			}


 		}//$_SERVER['REQUEST_METHOD'] == 'POST'

 ?>
<h1 class="text-center"><?php echo lang("CREATE_NEW_AD"); ?></h1>

<div class=""> <!--parent class-->

<!-- Start block 1 -->
<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo lang("CREATE_NEW_AD"); ?></div>
			<div class="panel-body">
				<div class="row">
					<!-- start Form -->
					<div class="col-md-8"> 
						<?php 	

					 		if(isset($_GET['success']) && $_GET['success']=1){
					 			echo "<div class='alert alert-success text-center'>".
										lang("ITEM_ADDED") 					
					 				."</div>";
					 		}
						 ?>						 
						<form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
							<!--Start Name field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label"><?php echo lang("NAME"); ?></label>
								<div class="col-sm-10 col-md-6">
									
									<input 
									pattern=".{2,14}"
									title="2-14 characters"
									type="text" 
									name="name" 
									class="form-control live-name" 
									value="<?php echo isset($_SESSION['old_data']['name']) ? $_SESSION['old_data']['name'] : '';  ?>" 
									placeholder="<?php echo lang("PLC_HLD_IN"); ?>" 
									required="required" />
									
									<?php 
										if(isset($_SESSION['errors']['name_len']))
											echo "<label style='color:red'> ". $_SESSION['errors']['name_len'] . " </label>" ;
										unset($_SESSION['errors']['name_len']);

										if(isset($_SESSION['errors']['name_f']))
											echo "<label style='color:red'> ". $_SESSION['errors']['name_f'] . " </label>" ;
										unset($_SESSION['errors']['name_f']);										 	
									 ?>

								</div>
							</div>
							<!--End Name field-->

							<!--Start Description field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label"><?php echo lang("DESCRIPTION"); ?></label>
								<div class="col-sm-10 col-md-6">
									<input
									 pattern=".{10,200}"
									 title="10-200 characters"
									 type="text" 
									 name="description" 
									 class="form-control live-desc" 
									 value="<?php echo isset($_SESSION['old_data']['description']) ? $_SESSION['old_data']['description'] : '';   ?>" 
									 placeholder="<?php echo lang("PLC_HLD_DI"); ?>" 
									 required="required" />
									
									<?php 
										if(isset($_SESSION['errors']['description']))
											echo "<label style='color:red'> ". $_SESSION['errors']['description'] . " </label>" ;
										unset($_SESSION['errors']['description']); 	
									 ?>	

								</div>
							</div>
							<!--End Description field-->


							<!--Start Price field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label"><?php echo lang("PRICE"); ?></label>
								<div class="col-sm-10 col-md-6">
									<input
									 type="text" 
									 name="price" 
									 class="form-control live-price" 
									 value="<?php echo isset($_SESSION['old_data']['price']) ? $_SESSION['old_data']['price'] : '';   ?>" 
									 placeholder="<?php echo lang("PLC_HLD_IP"); ?>" 
									 required="required" />
									 <select name='currency' class="live-currency" required="required" >
									 	<option <?php if( isset($_SESSION['old_data']['currency'])  && $_SESSION['old_data']['currency']=="0")echo "selected"; ?> value="0"; >....</option>
									 	<option <?php if( isset($_SESSION['old_data']['currency'])  && $_SESSION['old_data']['currency']=="$")echo "selected";  ?> > <?php echo lang("US_DOLLAR"); ?></option>
									 	<option <?php if( isset($_SESSION['old_data']['currency'])  && $_SESSION['old_data']['currency']=="JD")echo "selected";  ?> ><?php echo lang("JD"); ?></option>
									 </select>
									 <?php 
										if(isset($_SESSION['errors']['price']))
											echo "<label style='color:red'> ". $_SESSION['errors']['price'] . " </label>" ;
										unset($_SESSION['errors']['price']); 	
										
										if(isset($_SESSION['errors']['currency']))
											echo "<label style='color:red'> ". $_SESSION['errors']['currency'] . " </label>" ;
										unset($_SESSION['errors']['currency']); 	
									 									 

									 ?>
								</div>
							</div>
							<!--End Price field-->


							<!--Start Production_Country field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 control-label"><?php echo lang("COUNTRY"); ?></label>
								<div class="col-sm-10 col-md-6">
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
								<label class="col-sm-3 col-xs-8 control-label"><?php echo lang("STATUS"); ?></label>
								<div class="col-sm-10 col-md-6 col-xs-5">
									<select name="status" class="form-control">

										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="0")echo "selected";  ?> value="0">.....</option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="1")echo "selected";  ?> value="1"><?php echo lang("NEW"); ?></option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="2")echo "selected";  ?> value="2"><?php echo lang("ALMOST_NEW"); ?></option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="3")echo "selected";  ?> value="3"><?php echo lang("USED"); ?></option>
										<option <?php if( isset($_SESSION['old_data']['status'])  && $_SESSION['old_data']['status']=="4")echo "selected";  ?> value="4"><?php echo lang("NEED_TO_FIX"); ?></option>
									</select>
									<?php 
										if(isset($_SESSION['errors']['status']))
											echo "<label style='color:red'> ". $_SESSION['errors']['status'] . " </label>" ;
										unset($_SESSION['errors']['status']); 	
									 ?>
								</div>
							</div>
							<!--End Status field-->


							<!--Start categories field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 col-xs-8 control-label"><?php echo lang("CATEGORY"); ?></label>
								<div class="col-sm-10 col-md-6 col-xs-5">
									<select name="category" class="form-control">

										<option <?php if( isset($_SESSION['old_data']['category'])  && $_SESSION['old_data']['category']=="0")echo "selected";  ?> value="0">.....</option>
										<?php 

											$categs=getAll("*", "categories" , "parent=0", "ID" );
											foreach($categs as $category)
											{
												$sel="";
												if( isset($_SESSION['old_data']['category'])  && $_SESSION['old_data']['category']==$category['ID'] )
													{$sel="selected";}
												echo "<option $sel value='".$category['ID']."'>".$category['Name']."</option>";
												
												$childCats=getAll("ID,Name","categories","parent={$category['ID']}");
												foreach($childCats as $child){
													$sel="";
													if( isset($_SESSION['old_data']['category'])  && $_SESSION['old_data']['category']==$child['ID'] )
														{$sel="selected";}	

													echo "<option $sel value='".$child['ID']."'>&nbsp&nbsp&nbsp".$child['Name']."</option>";	
												}
											}

										 ?>

									</select>
									<?php 
										if(isset($_SESSION['errors']['category']))
											echo "<label style='color:red'> ". $_SESSION['errors']['category'] . " </label>" ;
										unset($_SESSION['errors']['category']); 	
									 ?>
								</div>
							</div>
							<!--End categories field-->

							<!--Start tags field-->
							<div class="form-group form-group-lg">
								<label class="col-sm-3 col-xs-8 control-label"><?php echo lang("TAGS"); ?></label>
								<div class="col-sm-10 col-md-6 col-xs-5">
									<input
									 type="text" 
									 name="tags" 
									 class="form-control" 
									 value="<?php echo isset($_SESSION['old_data']['tags']) ? $_SESSION['old_data']['tags'] : '';  unset($_SESSION['old_data']['tags']);  ?>" 
									 placeholder="<?php echo lang("PLC_HLD_TAGS"); ?>" /> 
									  
								</div>
							</div>
							<!--End tags field-->							
	


							<!--Start submit field-->
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10 col-md-4">
									<input type="submit" value="<?php echo lang("ADD_ITEM"); ?>" class="btn btn-primary btn-lg" >
								</div>
							</div>
							<!--End submit field-->

						</form>

					</div>
					<!-- End Form -->

					<!-- Start AD -->
					<div class="col-md-4">
						<div class='thumbnail item-box live-preview'>
							<span class='price-tag'>
							<?php
							 echo isset($_SESSION['old_data']['price']) ? $_SESSION['old_data']['price'] : '0$';
							 unset($_SESSION['old_data']['price']);  
							 if( isset($_SESSION['old_data']['currency']) ) 
							 		if($_SESSION['old_data']['currency'] == "US dollar")
							 			echo " $";
							 		else	
							 			echo " " . $_SESSION['old_data']['currency'] ;


							 ?> 
								
								
							</span>
							<img class='img-responsive' src='layout/images/HiLogo.png' alt='' />	
							<div class='caption'>
								<h3>
								<?php echo isset($_SESSION['old_data']['name']) ? $_SESSION['old_data']['name'] : 'Title';  ?>	
								
								</h3>
								<p>
								<?php echo isset($_SESSION['old_data']['description']) ? $_SESSION['old_data']['description'] : 'Description';  ?>
								</p>
							</div>
						</div>
					</div>
					<?php 
						unset($_SESSION['errors']);
						unset($_SESSION['old_data']);
					 ?>
					<!-- End AD -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End block 1 -->

</div>
<?php
}else{    //if(isset($_SESSION['user']))
	
	header("Location: login.php");	
} 
include $tpl . "footer.php";  //footer file
ob_end_flush();
 ?>   