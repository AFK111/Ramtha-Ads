<?php	session_start(); include "init.php"; ?>

	<div class="container">
		<h1 class="text-center"> <?php echo str_replace(".1,1." ,"&",$_GET['pagename']); ?> </h1>	
		<div class="row">	
			<?php 
			$items=getItems($_GET['pageid']);
			if(!empty($items)){

				foreach($items as $item){
				$currency = ($item['Currency']=='US dollar') ? "$" : $item['Currency'];
				echo "<div class='col-md-3 col-sm-6'>";
					echo "<div class='thumbnail item-box'>";
						echo "<span class='price-tag'>".$item['Price']." $currency</span>";
						echo "<img class='img-responsive' src='layout/images/HiLogo.png' alt='' />";	
						echo "<div class='caption'>";
							echo "<h3>".$item['Name']."</h3>";
							echo "<p>".$item['Description']."</p>";
						echo "</div>";
					echo "</div>";
				echo "</div>";	
				}

			}else 
				echo "<div class='nice-message'>".lang("NO_ITEMS")."</div>";
			 ?>
		</div>
	</div>

<?php include $tpl . "footer.php";  //footer file ?>   