<?php
session_start();
if(isset($_SESSION['Username'])){

  include "init.php"; ?>
   
		
		<div class="container">

			<?php for($i=0;$i<20;$i++){  ?>
			<!-- Start Card 1 -->
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">		
					
					

					<div class="card" style="width: 28rem; ">
						<div class="card-header">
                       		CardHeader
                    	</div>	
					  <img class="card-img-top" src="layout/images/noImage.png" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title">Card title</h5>
					    <p class="card-text"></p>
					    <a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					</div>
				</div>	
				
			<?php } ?>
			<!-- End Card 1 -->

		</div>	
			
<?php 
include $tpl . "footer.php"; 
}
else echo "See you in index page";


?>

