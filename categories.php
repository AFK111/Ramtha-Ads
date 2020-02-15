<?php	session_start(); include "init.php"; ?>

	<div class="container">
		<h1 class="text-center">  </h1>	
		<div class="row">	
			<?php 
			if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
				$pageid=$_GET['pageid'];
				$items=getAll("*","items","Approve=1 AND Cat_ID=$pageid","Item_ID");
				//$items=getItems("Cat_ID",$_GET['pageid']); // get just approved Ads
				if(!empty($items)){

					foreach($items as $item){
					$currency = ($item['Currency']=='US dollar') ? "$" : $item['Currency'];
					echo "<div class='col-md-3 col-sm-6'>";
						echo "<div class='thumbnail item-box'>";
							echo "<span class='price-tag'>".$item['Price']." $currency</span>";
							echo "<img class='img-responsive' src='layout/images/HiLogo.png' alt='' />";	
							echo "<div class='caption'>";
								//echo "<h3>".$item['Name']."</h3>";
								echo "<h3><a href='item.php?itemid=". $item['Item_ID'] ."'>".$item['Name']."</a></h3>";
								echo "<p>".$item['Description']."</p>";
	                            echo "<div class='date'>".$item['Add_Date']."</div>";

							echo "</div>";
						echo "</div>";
					echo "</div>";	
					}

				}else 
					echo "<div class='nice-message'>".lang("NO_ITEMS")."</div>";
			 }else//if(isset($_GET['pageid']))
			 	echo "<div class='alert alert-danger'>".lang("MSG_ERR_NO_ID")."<div>";
			 ?>
		</div>
	</div>

<?php include $tpl . "footer.php";  //footer file ?>   