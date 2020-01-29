<?php 
	
	function lang( $phrase ){
		static $lang = array(

			//Index page

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
			'NO_ITEMS'	=> 'There are no items yet in this cats',			
						

		);

		return $lang[$phrase];
	}

 ?>