<?php 
	
	function lang( $phrase ){
		static $lang = array(

			//Navbar links

			'CLUBNAME' 			=> 'Ramtha',
			'CATEGORIES' 		=> 'Categories',
			'ITEMS'				=>'Items',
			'MEMBERS'			=>'Members',
			'STATISTICS'		=>'Statistics',
			'LOGS'				=>'Logs',
			'EDIT PROFILE' 		=> 'Edit Profile',
			'SETTINGS' 			=> 'Settings',
			'LOGOUT' 			=> 'Logout',
			'DEFAULT'       	=>'Default',

			//members page
				
			'USERNAME'     		=>'Username',
			'PASSWORD'     		=>'Password',
			'REPASSWORD'     	=>'Repassword',
			'EMAIL'        		=>'Email',
			'FULL NAME'       	=>'Full name',
			'SAVE'     	   	   	=>'Save',

			'CURRENT PASSWORD' 	=> 'Current password (mandatory)',
			'NEW PASSWORD'     	=> 'New password (optional)',
			'REWRITE PASSWORD'  => 'Rewrite your password',
			'WPASSWORD'		   	=> '*Wrong password',

			'ERR_USERNAME'      => 'User name cannot be less than 3 characters or more than 20 characters',
			'ERR_NPASSWORD'     => 'New password cannot be less than 5 characters or more than 300 characters ',
			'ERR_EMAIL'      	=> 'Wrong email format',
			'ERR_EMAIL_LEN'     => 'Email cannot be more than 200 characters',
			'ERR_FULLNAME'      => 'Full name cannot be less than 3 characters or more than 200 characters',
			'ERR_PASSWORD'     	=> 'password cannot be less than 5 characters or more than 300 characters ',
			'ERR_REPASS'     	=> 'Repassword must match the password ',
			'ERR_EMPTY_PASS'    => 'password cannot be empty',
			'ERR_USER_EXIST'    => 'User name is used ',
			
			'ADD_MEMBER'        =>'Add member',
			'INSERT_MEMBER'     =>'Insert member',
			'MANAGE_MEMBERS'    =>'Manage members',

			'#ID'				=>'#ID',
			'USER_NAME'			=>'User name',
			'EMAIL'				=>'Email',
			'FULL_NAME'			=>'Full name',
			'REGISTERED_DATE'	=>'Registered date',
			'CONTROL'			=>'Control',
			'EDIT'				=>'Edit',
			'DELETE'			=>'Delete',
			'ACTIVATE'			=>'Activate',
			'ADD_NEW_MEMBER'	=>'Add new member',
			'RECORD_INSERTED'	=>'record inserted',

			'MSG_ERR_CNT_BROWSE'=>"You cann't browse this page directly",
			'MSG_ERR_NO_ID'		=>'There is no such ID',
			'EDIT_MEMBER'		=>'Edit member',
			'UPDATE_MEMBER'		=>'Update member',
			'RECORD_UPDATED'	=>'record updated',
			'DELETE_MEMBER'		=>'Delete member',
			'RECORD_DELETED'	=>'record deleted',
			'ACTIVATE_MEMBER'	=>'Activate member',
			'RECORD_ACTIVATED'  =>'Record activated',

			//categories page

			'ADD_NEW_CATEGORY' => 'Add new category',

			'NAME' 			   =>'Name',
			'DESCRIPTION'      =>'Description',
			'ORDERING'         =>'Ordering',
			'VISIBLE'          =>'Visible',
			'ALLOW_COMMENTING' =>'Allow to comment',
			'ALLOW_ADS'		   =>'Allow Ads',		
			'ADD_CATEGORY'	   =>'Add category',
			'PLC_HLD_CN'	   =>'Category name',
			'PLC_HLD_DC'	   =>'Describe the category',
			'PLC_HLD_SC'	   =>'Enter number to sort the category with',		

			'INSERT_CATEGORY' =>'Insert category',
			'ERR_CNAME_EMPT'  =>'You can not leave category name empty',
			'ERR_CEXIST'	  =>'This category is exist',
			'ERR_DESC_EMPT'   =>'You must describe the category',
 			'ERR_CNAME_LEN'	  =>'Name must be more than 2 characters less than 50 characters',	
 			'ERR_DESC_LEN'    =>'The description must be more than 4 characters and less than 100 characters',
		
 			'MANAGE_CATEGORIES' => 'Manage categories',
 			'HIDDEN' 			=> 'Hidden',
			'NO_COMMENTING'		=>'No commenting',
			'NO_ADS'  			=>'No Ads',





		);

		return $lang[$phrase];
	}

 ?>