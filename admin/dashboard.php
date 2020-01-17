<?php

	ob_start();  //Output buffering start (this to solve headers sent error)

	session_start();
	if(isset($_SESSION['Username'])){
		$pageTitle="Dashboard";
		include "init.php";          //header is here

		/* Start Dashboard page*/

		$theLatest = getLatest("*","users","UserID",5);  // get the last five users registered to print them in the panel body below 
		
?>
			
		<div class="container home-stats text-center">
			
			<h1>Dashboard</h1>	
			<div class="row">

				<div class="col-md-3">
					<div class="stat st-members">
						Total members
						<span > <a href="members.php"> <?php echo countItems("UserID","users"); ?>  </a> </span>
					</div>
				</div>		

				<div class="col-md-3">
					<div class="stat st-pending">
						Pending members
						<span> <a href="members.php?do=Manage&page=Pending">
							<?php echo checkItem("RegStatus" , "users" , 0); ?>
						</a> </span>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-items">
						Total items
						<span><a href="items.php">	<?php echo countItems("Item_ID" , "items"); ?> </a></span>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-comments">
						Total comments
						<span>200</span>
					</div>
				</div>

			</div>

		</div>

		<div class="container latest">

			<div class="row">
				
				<div class="col-sm-6">
					<div class="panel panel-default">
					
						<div class="panel-heading">
							<i class="fa fa-users" style="color:#3437BC;"></i> Latest registered users
						</div>
						<div class="panel-body">
							
							<ul class="list-unstyled latest-users" >	
								<?php 
										foreach ($theLatest as  $row) {
											echo "<li>" ;
												echo "<b>" . $row['UserName']  . "</b>";
												echo "<a href='members.php?do=Edit&userid=" . $row['UserID'] . "'>";
										 		echo "<span class='pull-right'> <i class='fa fa-edit'></i> Edit </span>";
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
							<i class="fa fa-tag" style="color:#3437BC;"></i> Latest items
						</div>
						<div class="panel-body">
							Test
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





