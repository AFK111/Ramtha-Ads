<?php

	ob_start();  //Output buffering start (this to solve headers sent error)

	session_start();
	if(isset($_SESSION['Username'])){
		$pageTitle="Dashboard";
		include "init.php";          //header is here

		/* Start Dashboard page*/

		$theLatestU = getLatest("*","users","UserID",5   ,"RegStatus");  // get the last five users registered to print them in the panel body below 
		$theLatestI=  getLatest("*","items","Item_ID",5 ,"Approve"); //get the last five items registered to print them in the panel body below		
?>
			
		<div class="container home-stats text-center">
			
			<h1>Dashboard</h1>	
			<div class="row">

				<div class="col-md-3">
					<div class="stat st-members">
						<i class="fa fa-users"></i>	
						<div class="info">
							<?php echo lang("TOTAL_MEMBERS"); ?>
							<span > <a href="members.php"> <?php echo countItems("UserID","users"); ?>  </a> </span>
						</div>
					</div>
				</div>		

				<div class="col-md-3">
					<div class="stat st-pending">
						<i class="fa fa-user-plus"></i>
						<div class="info">
							<?php echo lang("PENDING_MEMBERS"); ?>
							<span> <a href="members.php?do=Manage&page=Pending"><?php echo checkItem("RegStatus" , "users" ,0); ?></a> </span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-items">
						<i class="fa fa-tag"></i>
						<div class="info">
							<?php echo lang("TOTAL_ITEMS"); ?>
						<span><a href="items.php">	<?php echo countItems("Item_ID" , "items"); ?> </a></span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-pending-c">
						<i class="fa fa-plus"></i>
						<div class="info">
							<?php echo lang("PENDING_ITEMS"); ?>
							<span> <a href="items.php?do=Manage&page=Pending"><?php echo checkItem("Approve" , "items" ,0); ?></a> </span>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="container latest">

			<div class="row">
				
				<div class="col-sm-6">
					<div class="panel panel-default">
					
						<div class="panel-heading">
							<i class="fa fa-users" style="color:#3437BC;"></i> <?php echo lang("LATEST_USERS"); ?>
							<span class="toggle-info pull-right">
								<i class="fa fa-minus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							
							<ul class="list-unstyled latest-users" >	
								<?php 
										foreach ($theLatestU as  $row) {
											echo "<li>" ;
												echo "<b>" . $row['UserName']  . "</b>";
												echo "<a href='members.php?do=Edit&userid=" . $row['UserID'] . "'>";
										 		echo "<span class='pull-right'> <i class='fa fa-edit'></i> ". lang("EDIT") ." </span>";
										 		echo "</a>";
										 	echo "</li>";				
										 }	
								 ?>
						    </ul>
						</div>
					</div>		
				</div>

				<div class="col-sm-6">
					<div class="panel panel-default">
					
						<div class="panel-heading">
							<i class="fa fa-tag" style="color:#3437BC;"></i> <?php echo lang("LATEST_ITEMS"); ?>
							<span class="toggle-info pull-right">
								<i class="fa fa-minus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users" >	
								<?php 
										foreach ($theLatestI as  $row) {
											echo "<li>" ;
												echo "<b>" . $row['Name']  . "</b>";
												echo "<a href='items.php?do=Edit&itemid=" . $row['Item_ID'] . "'>";
										 		echo "<span class='pull-right'> <i class='fa fa-edit'></i> ". lang("EDIT") ." </span>";
										 		echo "</a>";
										 	echo "</li>";				
										 }	
								 ?>
						    </ul>
						</div>
					</div>		

				</div>
			
			</div>
		
		</div>

<?php
		/* End Dashboard page*/




	 	include $tpl . "footer.php";  //footer file 
	 }
	else{
		header('Location: index.php');
		exit();
	}

	ob_end_flush();   //Output buffering stop (this to solve headers sent error)
?>





