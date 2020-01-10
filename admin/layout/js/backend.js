$(function(){  //document ready code

	'use strict';

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
	var passField = $('.password');

	$('.show-pass').mouseup(function(){

		passField.attr('type','password');

	}).mousedown(function(){
		passField.attr('type','text');
	});
	
	//Confirmation message on Button 

	$('.confirm').click(function(){

		return confirm('Are you sure ?');
	});

});