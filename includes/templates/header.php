<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php getTitle(); ?></title>
	<link href="https://fonts.googleapis.com/css?family=Courier+Prime&display=swap" rel="stylesheet"> <!-- google font-->
	<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
	
	
	 
	
</head>

<body>


<!-- Start upper bar -->
<div class="upper-bar">
  <div class='container'>
    <?php if(isset($_SESSION['user'])){ ?>
        <span class='pull-right'> <a href="profile.php"> <?php echo $_SESSION['user']; ?> </a>| <a href="logout.php" class="btn btn-danger"><?php echo lang("LOGOUT"); ?></a> </span>
        <span ><a href="newad.php"> <?php echo lang("NEW_AD"); ?> </a></span>
        <?php
            $active= checkUserStatus($_SESSION['user']);   
            if(!$active){
              //user not active
            }
         ?>    
    <?php }else{ ?> 
    
    <a href="login.php">
      <span class="pull-right"><?php echo lang("LOGIN_SIGNUP"); ?></span>
    </a>
    <?php } ?>
  </div>
</div>
<!-- End upper bar -->

<!--Start navbar  -->

<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"> <?php echo lang("CLUBNAME"); ?> </a>
    </div>


    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php 

            foreach(getCat() as $cat){
              echo "<li>
                    <a href='categories.php?pageid=" . $cat["ID"] ."'>"  
                      .$cat['Name']. 
                    "</a>
                    </li>";    
            }

         ?>
      </ul>
  
    </div>
  </div>
</nav>

<!--End navbar  -->