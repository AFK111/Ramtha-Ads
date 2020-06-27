<?php
	session_start();
 	$pageTitle="Ramtha's Adds";
	//Error reporting
	ini_set('display_errors','on');
	error_reporting(E_ALL);

	$sessionUser='';
	if( isset($_SESSION['user']) )
		$sessionUser=$_SESSION['user'];     //we declare this variable because if we print or use unfound $_SESSION['user'] ...
											//... deal with it as empty instead of undefined .
	//Routes

	$tpl  = 'includes/templates/';    // Template directory
	$lang ='includes/languages/';     //language directory
	$func = 'includes/functions/';    //functions directory
	$css  = 'layout/css/';            //css directory
	$js   = 'layout/js/';             //js directory
	

	//includes important files
	include $func . "/functions.php";
	include $lang . "english.php";
	include 'admin/connect.php';
	include    $tpl . "header.php";  //navbar is here	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="layout/css/indexPageStyle.css">
	
    <title>Ramtha Ads</title>
</head>
<body>
	

    <!-- Start Header -->
    <header class="showcase">
        <div class="content">
            <img src="layout/images/HiLogo.png" class="logo" alt="RamthaFC">
            <div class="title">Welcom To Ramtha Ads</div>
            <div class="text">You can put advertisement freely to Ramtha's people </div>
        </div>
    </header>
    <!-- End Header -->

    <!-- Start Services -->
    <section class="services">
        <div class="container1 grid-3 center">
            <div>
                <i class="fa fa-users fa-4x" ></i>
                <h3><?php echo countUsers(); ?> Users</h3>
                <p>Large number of users and advertisers that could see your products. </p>
            </div>
            
            <div>
				<i class="fa fa-address-card fa-4x"></i>
                <h3>Ramtha's People</h3>
                <p>Your products must be directed for Just Ramtha's Poeple so here you will put and see efficient advertisements because you already knew the audience  .</p>
            </div>

            <div>
				<i class="fa fa-gift fa-4x"></i>
                <h3>Gifts to users</h3>
                <p>Each month we will have a winner from our users . the winner will gain 10% of website profits of that month .</p>
            </div>
        </div>
        
    </section>
    <!-- End Services -->

    <!-- Start About -->
    <section class="about bg-light">
        <div class="container1">
            <div class="grid-2">
                <div class="center">
                    <img src="layout/images/HiLogo.png" alt="">
                </div>
                <div>
                    <h3>About Us</h3>
                    <p>
						We are a group of developers and designers who pursue to make this website more helpful to the traders . 
						We also pursue to make the reachment to Ramtha's People more easy to the traders from any where .
					</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End About -->


    <!-- Start Footer -->
    <footer class="center bg-dark">
        <p>AFK &copy; 2020</p>
    </footer>
	<!-- End Footer -->
	
		<script src="<?php echo $js; ?>jquery-3.4.1.min.js"></script>
		<script src="<?php echo $js; ?>bootstrap.min.js"></script>
		<script src="<?php echo $js; ?>frontend.js"></script>
</body>
</html>