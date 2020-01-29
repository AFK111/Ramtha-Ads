<?php
	session_start();
 	$pageTitle="Profile";
 	include "init.php"; ?>
<h1 class="text-center">My Profile</h1>

<!-- Start info block 1 -->
<div class="profile"> <!--parent class-->
	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My info</div>
				<div class="panel-body">
				Name:AFK1
				</div>
			</div>
		</div>
	</div>
	<!-- End info block 1 -->
	<!-- Start info block 2 -->
	<div class="my-ads block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">MY ads</div>
				<div class="panel-body">
				Test ads
				</div>
			</div>
		</div>
	</div>
	<!-- End info block 2 -->
	<!-- Start info block 3 -->
	<div class="my-comments block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">latest Comment</div>
				<div class="panel-body">
					Test comments
				</div>
			</div>
		</div>
	</div>
	<!-- End info block 3 -->
</div>
 	<?php 
	include $tpl . "footer.php";  //footer file
 ?>   