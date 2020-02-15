<?php
	ob_start();
	session_start();
 	$pageTitle="Profile";
 	include "init.php"; 

 	if(isset($_SESSION['user'])){
 		$stmt=$con->prepare("SELECT * FROM users WHERE UserName = ?");
 		$stmt->execute(array($sessionUser));  //$session user var is the same of $_SESSION['user'] , initialized in the init.php file .
 		$info=$stmt->fetch();

 ?>
<h1 class="text-center"><?php echo lang("MY_PROFILE"); ?></h1>

<div class="profile"> <!--parent class-->
<!-- Start info block 1 -->
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo lang("MY_INFO"); ?>
				<a href="#" class="btn btn-default pull-right"><?php echo lang("EDIT"); ?></a> 
			</div>
			<div class="panel-body">
			<ul class="list-unstyled">	
				<li>
					<i class="fa fa-unlock-alt fa-fw"></i>
					<span><?php echo lang("LOGIN_NAME"); ?></span>: <?php echo " ".$info['UserName']; ?> 
				</li>	
				<li>
					<i class="fa fa-envelope fa-fw"></i>
					<span><?php echo lang("EMAIL"); ?></span>: <?php echo " ".$info['Email']; ?> 
				</li>	
				<li>
					<i class="fa fa-user fa-fw"></i>
					<span><?php echo lang("FULLNAME"); ?></span>: <?php echo " ".$info['FullName']; ?>
				</li>	
				<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span><?php echo lang("REGISTERED_SINCE"); ?></span>: <?php echo " ".$info['Date']; ?> 
				</li>	
				<li>
					<i class="fa fa-tags fa-fw"></i>
					<span><?php echo lang("FAV_CATEGORY"); ?></span>: Under development
				</li>		
			</ul>
			</div>
		</div>
	</div>
</div>
<!-- End info block 1 -->

<!-- Start Ads block 2 -->
<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo lang("MY_ITEMS"); ?></div>
			<div class="panel-body">
				<div class="row">	
					<?php
					$memberid=$info['UserID'];
					$items=getAll("*" , "items" ,"Member_ID=$memberid" ,"Item_ID" ,"DESC");
					//$items=getItems("Member_ID" , $info['UserID'] , 1);  //1 means get all ads even those that are not approved
					if(!empty($items)){

						foreach($items as $item){
						$currency = ($item['Currency']=='US dollar') ? "$" : $item['Currency'];
						echo "<div class='col-md-3 col-sm-6'>";
							echo "<div class='thumbnail item-box'>";
								if( $item['Approve'] == 0) {echo "<span class='approve-status'>not approved</span>";}
								echo "<span class='price-tag'>".$item['Price']." $currency</span>";
								echo "<img class='img-responsive' src='layout/images/HiLogo.png' alt='' />";	
								echo "<div class='caption'>";
									echo "<h3><a href='item.php?itemid=". $item['Item_ID'] ."'>".$item['Name']."</a></h3>";
									echo "<p>".$item['Description']."</p>";
									echo "<div class='date'>".$item['Add_Date']."</div>";
								echo "</div>";
							echo "</div>";
						echo "</div>";	
						}

					}else 
						echo "<div class='nice-message'>".lang("NO_ITEMS")." <a href=newad.php>".lang("CREATE_NEW_AD")."</a>" ."</div>";
					 ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Ads block 2 -->

<!-- Start comments block 3 -->
<div id="my-comments" class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo lang("MY_COMMENTS"); ?></div>
			<div class="panel-body">
			<?php
				
				$comments=getAll("Comment" , "comments" ,"User_ID=$memberid");
				if(!empty($comments)){
					
					foreach($comments as $comment){
						echo '<p class="nice-message"  style="border-left: 5px solid #080;">'. $comment['Comment'] .'</p>';
					}

				}else{
					echo "<div class='row'><div class='nice-message'>".lang("NO_COMMENTS")."</div></div>";
				}

			 ?>
				
			</div>
		</div>
	</div>
</div>
<!-- End comments block 3 -->
</div>
<?php
}else{    //if(isset($_SESSION['user']))
	
	header("Location: login.php");	
} 
include $tpl . "footer.php";  //footer file
ob_end_flush();
 ?>   