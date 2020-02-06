<?php 
	
	function lang( $phrase ){
		static $lang = array(

			//Index page
			'MSG_ERR_NO_ID'		=>'There is no such ID',

			//Navbar links
			'CLUBNAME' 		=> 'Ramtha',
			'DEFAULT'		=> 'Default',
			'LOGOUT'		=>'Logout',
			'LOGIN'			=>'Login',
			'USERNAME'		=>'Username',
			'PASSWORD'		=>'Password',
			'SIGNUP'		=>'SignUp',
			'REPASSWORD'	=>'Rewrite Password',
			'EMAIL'			=>'email',
			'LOGIN_SIGNUP'	=>'Login-Signup',
			
			//categories page
			'NO_ITEMS'	   => 'There are no items yet',
			'NO_COMMENTS'  => 'There are no comments yet',

			//login and singup page
			'ERR_USERNAME'  =>'3-20 characters',
			'ERR_PASSWORD'	=>'5-300 characters',
			'ERR_REPASS'	=>'must math password field',
			'ERR_EMAIL'		=>'must be like e1mail@email.com',			
			'ERR_EMAIL_LEN' =>'less than 200 characters',			
			'ERR_USER_EXIST'=>'User name is used',
			'MSG_SUCCESS_REG'=>'We glad you are one of our clients ...',

			//profile page
			'MY_PROFILE'	   =>'My Profile',	 
			'LOGIN_NAME'	   =>'Login Name',
			'EMAIL'			   =>'Email',
			'FULLNAME'		   =>'FullName',
			'REGISTERED_SINCE' =>'Client Since',
			'FAV_CATEGORY'	   =>'Fav Category',
			'CREATE_NEW_AD'	   =>'Create New Ad',	
			'NEW_AD'		   =>'New Ad',

			//newad page

			'ADD_ITEM'			=>'Add item',			
			
			'RATING'			=>'Rating',
			
			'ERR_LEN_INAME'		  =>'<div class="alert alert-danger">Item name must be between 2 and 14 characters</div>',
			'ERR_FORMAT_INAME'	  =>'<div class="alert alert-danger">Item name must start with letter</div>',
			'ERR_LEN_DESCRIPTION' =>'<div class="alert alert-danger">Item description must be between 10 and 200 characters</div>',
			'ERR_EMP_PRICE'		  =>'<div class="alert alert-danger">Price can not be empty</div>',
			'ERR_FORMAT_PRICE'    =>'<div class="alert alert-danger">Price must contain only numbers and decimal separator like this (10 digits at most . 2 digit at most)</div>',
			'ERR_EMP_STATUS'	  =>'<div class="alert alert-danger">You must choose the status of item</div>',
			'ERR_EMP_CURRENCY'	  =>'<div class="alert alert-danger">You must choose currency</div>',		
			'ERR_EMP_CATEGORY'	  =>'<div class="alert alert-danger">You must choose a category</div>',	

			'NAME'				  =>'Name',
			'DESCRIPTION'		  =>'Description',	
			'PRICE'				  =>'Price',
			'COUNTRY'			  =>'Country',
			'STATUS'			  =>'Status',
			'CATEGORY'			  =>'Category',	
			'US_DOLLAR'			  =>'$',
			'JD'				  =>'JD',
			'NEW'				  =>'New',
			'ALMOST_NEW'		  =>'Almost new',
			'USED'				  =>'Used',
			'NEED_TO_FIX'		  =>'Need to fix',


			'PLC_HLD_IN'		=>'Item name',
			'PLC_HLD_DI'		=>'Describe the item',
			'PLC_HLD_IP'		=>'Item price',
			'PLC_HLD_PC'		=>'The country that made the item',
			'ITEM_ADDED'		=>'Item Added Successfully',

			//item page

			'ADD_COMMENT'		=>'Add Comment',
			'ADD_YOUR_COMMENT'  =>'Add Your Comment',
			

	
		);

		return $lang[$phrase];
	}

 ?>