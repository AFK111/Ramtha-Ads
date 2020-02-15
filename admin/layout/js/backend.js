$(function(){  //document ready code

	'use strict';

	// Dashboard

	$('.toggle-info').click(function(){

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		( $(this).hasClass('selected') ) ? $(this).html('<i class="fa fa-plus fa-lg"></i>') : $(this).html('<i class="fa fa-minus fa-lg"></i>');


	

	});

	//Hide placeholder on form focus

	$('[placeholder]').focus(function(){

		$(this).attr('data-text',$(this).attr('placeholder'));

		$(this).attr('placeholder','');

		}).blur(function(){

			$(this).attr('placeholder',$(this).attr('data-text'));
		});

	//Add Asterisk on required filed
	
	$('input').each(function(){

		if($(this).attr('required') === 'required'){
			$(this).after('<span class="asterisk">*</span>');
		}

	});

	//Convert password field into text field on mousedown

	$('.show-pass').mouseup(function(){

		$(this).prevAll(".password").attr('type','password');

	}).mousedown(function(){
		$(this).prevAll(".password").attr('type','text');
	});
	
	//Confirmation message on Button 

	$('.confirm').click(function(){

		return confirm('Are you sure ?');
	});

	//Category view option

	$('.categories .cat h3').click(function(){

		$(this).next('.full-view').fadeToggle(100);

	});

	$('.option span').click(function(){
		$(this).addClass('active').siblings('span').removeClass('active');
		
		if($(this).data('view') === 'full')
			$('.cat .full-view').fadeIn(100);
		else
			$('.cat .full-view').fadeOut(100);
	});

	
	//show delete button on child categories
	$('.child-link').hover(function(){

		$(this).find('.show-delete').fadeIn(500);

	} , function(){

		$(this).find('.show-delete').fadeOut(1000);

	} ) ;	


	  

});