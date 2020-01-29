<?php 
	
	function lang( $phrase ){
		static $lang = array(

			'ADMIN_LOGIN' 		=>'Admin Login',

			//Navbar links

			'CLUBNAME' 			=> 'Ramtha',
			'CATEGORIES' 		=> 'Categories',
			'ITEMS'				=> 'Items',
			'MEMBERS'			=> 'Members',
			'COMMENTS'			=>'Comments',
			'STATISTICS'		=> 'Statistics',
			'LOGS'				=> 'Logs',
			'EDIT PROFILE' 		=> 'Edit Profile',
			'VISIT_SHOP'		=>'Visit shop',
			'SETTINGS' 			=> 'Settings',
			'LOGOUT' 			=> 'Logout',
			'DEFAULT'       	=> 'Default',

			//dashboard page
			'TOTAL_MEMBERS'		=>'Total members',
			'PENDING_MEMBERS'	=>'Pending members',
			'TOTAL_ITEMS'		=>'Total items',
			'TOTAL_COMMENTS'	=>'Total comments',
			'LATEST_USERS'		=>'Latest users',
			'LATEST_ITEMS'		=>'Latest items',
			'PENDING_ITEMS'		=>'Pending items',


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
			'ERR_DEL_C_WITH_I'=>'Sorry! , you can not delete this category because it contains items', 

 			'MANAGE_CATEGORIES' => 'Manage categories',
 			'HIDDEN' 			=> 'Hidden',
			'NO_COMMENTING'		=>'No commenting',
			'NO_ADS'  			=>'No Ads',

			'EDIT_CATEGORY'     =>'Edit category',
			'UPDATE_CATEGORY'	=>'Update category',
			'DELETE_CATEGORY'	=>'Delete category',


			//items page

			'ADD_NEW_ITEM'		=>'Add new item',
			'ADD_ITEM'			=>'Add item',
			'PLC_HLD_IN'		=>'Item name',
			'PLC_HLD_DI'		=>'Describe the item',
			'PRICE'				=>'Price',
			'PLC_HLD_IP'		=>'Item price',
			'COUNTRY'			=>'Country',
			'PLC_HLD_PC'		=>'The country that made the item',
			'STATUS'			=>'Status',
			'RATING'			=>'Rating',
			
			'INSERT_ITEM'		  =>'Insert item',
			'ERR_LEN_INAME'		  =>'Item name must be between 2 and 14 characters',
			'ERR_FORMAT_INAME'	  =>'Item name must start with letter',
			'ERR_LEN_DESCRIPTION' =>'Item description must be between 10 and 200 characters',
			'ERR_EMP_PRICE'		  =>'Price can not be empty',
			'ERR_FORMAT_PRICE'    =>'Price must contain only numbers and decimal separotor like this (10 digits at most . 2 digit at most)',
			'ERR_EMP_STATUS'	  =>'You must choose the status of item',
			'ERR_EMP_CURRENCY'	  =>'You must choose currency',	
			'ERR_EMP_MEMBER'	  =>'You must choose a member' ,	
			'ERR_EMP_CATEGORY'	  =>'You must choose a category',	

			'US_DOLLAR'			  =>'US dollar',
			'JD'				  =>'JD',
			'NEW'				  =>'New',
			'ALMOST_NEW'		  =>'Almost new',
			'USED'				  =>'Used',
			'NEED_TO_FIX'		  =>'Need to fix',

			'MEMBER'			  =>'Member',
			'CATEGORY'			  =>'Category',	
			'MANAGE_ITEMS'		  =>'Manage items',	
			'ADDED_BY'			  =>'Added by',

			'EDIT_ITEM'			  =>'Edit item',
			'UPDATE_ITEM'		  =>'Update item',
			'DELETE_ITEM'		  =>'Delete item',	
			'APPROVE'			  =>'Approve',
			'APPROVE_ITEM'		  =>'Approve item',
			'NO_ITEMS'			  =>'No items to show',	
			'PENDING'			  =>'Pending',	

			//comments page

			'MANAGE_COMMENTS'	  =>'Manage comments',	
			'ITEM_NAME'			  =>'Item Name',
			'EDIT_COMMENT'		  =>'Edit comment',	
			'COMMENT'			  =>'Comment',
			'UPDATE_COMMENT'	  =>'Update comment',
			'EMP_COMMENT'		  =>'Comment can not be empty',	
			'DELETE_COMMENT'	  =>'Delete comment',
			'APPROVE_COMMENT'	  =>'Approve comment',		
			'SHOW_COMMENTS'		  =>'Show comments',				
			'NO_COMMENT'		  =>'There are No comments yet...',	

		);

		return $lang[$phrase];
	}

 ?>