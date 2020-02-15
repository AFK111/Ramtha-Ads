<?php
	ob_start();
	session_start();
 	$pageTitle="Show item";
 	include "init.php"; 
 	
 	//Check if the get request 'item id' is numeric and get the integer value of it
	$itemid = ( isset($_GET['itemid']) && is_numeric($_GET['itemid']) ) ? intval($_GET['itemid']) : 0 ;
	
	//Select all data depend on the $itemid
	$stmt = $con->prepare("SELECT items.* , categories.Name AS CName, users.UserName AS UName 
						   FROM items
						   INNER JOIN categories ON categories.ID = items.Cat_ID
						   INNER JOIN users ON users.UserID = items.Member_ID
						   WHERE Item_ID=?

						   ");     
	$stmt->execute(array($itemid));
	$count=$stmt->rowCount();
	if($count>0){
		$item=$stmt->fetch();

		if($item['Approve']==0){
			echo "<h1></h1>";	
			echo "<div class='alert alert-danger text-center'>Need approval</div>";
		}
 ?>

<h1 class="text-center"><?php echo $item['Name']; ?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img src="layout/images/HiLogo.png" class="img-responsive img-thumbnail center-block" alt=''>	
		</div>

		<div class="col-md-9 item-info">
			<h2><?php echo $item['Name']; ?></h2>
			<p><?php echo $item['Description']; ?></p>
			<ul class="list-unstyled">
				<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span>Added Date </span> : <?php echo $item['Add_Date']; ?>
				</li>
				<li>
					<i class="fa fa-money"></i>
					<span>Price </span> : <?php echo $item['Price'] ." ". $item['Currency']; ?>
				</li>
				<li>
					<i class="fa fa-home fa-fw"></i>
					<span>Made In </span> : <?php echo $item['Production_Country']; ?>
				</li>
				<li>
					<i class="fa fa-tags fa-fw"></i>
					<span>Category </span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID']; ?>"><?php echo $item['CName'] ?></a>
				</li>
				<li>
					<i class="fa fa-user fa-fw"></i>
					<span>Added By </span> : <a href="#"><?php echo $item['UName'] ?></a>
				</li>
				<li class="tags-items">
					<i class="fa fa-user fa-fw"></i>
					<span>Tags </span> : 
					<?php 
						$allTags=explode(",", $item['Tags']);
						
						foreach($allTags as $tag){
							$tag=str_replace(" ", "", $tag);
							$lowerTag=strtolower($tag);
							if(!empty($tag))
								echo "<a href='tags.php?name={$lowerTag}'>". $tag . "</a> ";
						}
						
					 ?>
				</li>				
			</ul>
		</div>
	</div>

	<hr class="hr-item" />
		<?php if(isset($_SESSION['user'])) { ?>
		<!-- Start Add comment -->
		<div class="row">
			<div class='col-md-offset-3'>
				<div class="add-comment">
					<h3><?php echo lang('ADD_YOUR_COMMENT'); ?></h3>
					<form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']; ?>" method="POST">
						<textarea name="comment" required></textarea>
						<input type="submit" class="btn btn-primary"  value="<?php echo lang('ADD_COMMENT'); ?>">
					</form>
				<?php 
					if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
						
						$comment =filter_var($_POST['comment'] , FILTER_SANITIZE_STRING);
						$itemid  =$item['Item_ID'];
						$userid  =$_SESSION['userid'];
					
						if( !empty($comment) ){
						
							$stmt = $con->prepare("INSERT INTO
													 comments(comment , status , add_date , item_id , user_id)
													 VALUES(:zcomment , 0 ,now() , :zitemid , :zuserid)
												 ");
							$stmt->execute(array(
							'zcomment'=> $comment,
							'zitemid'=>$itemid,
							'zuserid'=>$userid,
							));
							
							if($stmt)
								echo "<div class='alert alert-success'>Comment Added</div>";
							
						}

					}
				 ?>
				</div>	
			</div>
		</div>
		<!-- End Add comment -->
		<?php }else{
			echo "<a href='login.php' target='_blank'>login or register</a> to add comment";
		} ?>
	<hr class="hr-item" />

	<?php
	    //Select all approved comments for current item
		$stmt=$con->prepare("SELECT comments.* , users.UserName AS UName
							 FROM comments
							 INNER JOIN users ON users.UserID=comments.User_ID
							 WHERE Item_ID = ? AND  Status=1
							 ORDER BY Add_Date DESC");
		$stmt->execute(array($itemid));	
		//Assign to variable
		$comments=$stmt->fetchAll();

	?>

	<div class="row">
		
		<?php foreach($comments as $comment){ ?>
				<div class="comment-box">
					<div class='row'>
						<div class='col-sm-2 text-center'>  <!-- UserInfo -->
						<img src="layout/images/HiLogo.png" class="img-responsive img-thumbnail img-circle center-block" alt />
						 <?php echo $comment['UName']; ?>
						</div> 
						<div class='col-sm-10'>          <!--  CommentInfo -->
						  	<p class='lead'><?php echo $comment['Comment']; ?> </p>	 
						</div>
					</div>
				</div>
				<hr class="hr-item" />
			<?php } ?>
		

	</div>
</div>


<?php
	}else{
		echo "<div class='alert alert-danger'>". lang("MSG_ERR_NO_ID") . "</div>";
	}
include $tpl . "footer.php";  //footer file
ob_end_flush();
 ?>   