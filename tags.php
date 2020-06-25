<?php	session_start(); include "init.php"; ?>

<div class="container">
	<h1 class="text-center">  </h1>	
	<div class="row">	
		<?php 
		if(isset($_GET['name'])){
			$tag=$_GET['name'];
			echo "<h1 class='text-center'>$tag</h1>";
			
			$tagItems=getAll("*","items","Approve=1 AND Tags LIKE '%$tag%'","Item_ID");
			if(!empty($tagItems)){

				foreach($tagItems as $item){
				$currency = ($item['Currency']=='US dollar') ? "$" : $item['Currency'];
				echo "<div class='col-md-3 col-sm-6'>";
					echo "<div class='thumbnail item-box'>";
						echo "<span class='price-tag'>".$item['Price']." $currency</span>";
						$img = $item['Image'];
						echo "<img class='img-responsive item-img' src='admin/uploads/adsPhotos/$img' alt='' />";	
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