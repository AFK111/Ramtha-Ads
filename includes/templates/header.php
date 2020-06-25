<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php getTitle(); ?></title>
	<link rel="icon" type="image/ico" href="admin/layout/images/HiLogo.png">
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
         
         <?php 
            $userinfo  = getAll("Avatar","users","UserName='{$_SESSION['user']}'");
            $userImage = empty($userinfo[0]['Avatar']) ? "noImage" : $userinfo[0]['Avatar'] ;
          ?>
         <a href="profile.php">
            <img class="img-thumbnail  avatar" src="admin/uploads/avatars/<?php echo $userImage; ?>" alt="">
            <span class="uname"><?php echo $_SESSION['user']; ?></span> 
         </a>
          


        <div class="btn-group pull-right my-info">
            <span class="btn dropdown-toggle menu-name" data-toggle="dropdown">
              <i class="fa fa-edit"></i>
              <span class=""><?php echo lang("SETTINGS"); ?></span>
              <span class="caret"></span>
            </span>
            <ul class="dropdown-menu">
              <li><a href="profile.php"><?php echo lang("MY_PROFILE"); ?></a></li>
              <li><a href="newad.php"><?php echo lang("ADD_NEW_ITEM"); ?></a></li>
              <hr class=hr-upper-bar>
              <li><a href="profile.php#my-ads"><?php echo lang("MY_ITEMS"); ?></a></li>
              <li><a href="profile.php#my-comments"><?php echo lang("MY_COMMENTS"); ?></a></li>
              <hr class=hr-upper-bar>
              <li><a href="logout.php"><?php echo lang("LOGOUT"); ?></a></li>
            </ul>
            
        </div>
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

            foreach(getAll("*","categories", "parent = 0" , "ID" ,"ASC") as $cat){
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