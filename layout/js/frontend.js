$(function(){  //document ready code

	'use strict';

	//Switch between login and signup
	$('.login-page h1 span').click(function(){
		
		$(this).addClass('selected').siblings().removeClass("selected");

		$('.login-page form').hide(); //hide all forms in the page
		$( '.' + $(this).data("class") ).fadeIn(500); //show the form of the span you click on
	});

	//Hide placeholder on form focus

	$('[placeholder]').focus(function(){

		$(this).attr('data-text',$(this).attr('placeholder'));

		$(this).attr('placeholder','');

		}).blur(function(){

			$(this).attr('placeholder',$(this).attr('data-text'));
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

	//live-name
	$('.live-name').keyup(function(){
		$('.live-preview .caption h3').text($(this).val()); 
	});


	//live-desc
	$('.live-desc').keyup(function(){
		$('.live-preview .caption p').text($(this).val()); 
	});


	//live-price
	$('.live-price').keyup(function(){
		$('.live-preview .price-tag').text($(this).val()); 
	});

	//live-currency
	$(".live-currency").change(function () {
    var selectedOption = $(this).val();
	if(selectedOption == 0)	selectedOption="";
	if(selectedOption == "US dollar") selectedOption="$";	
	
	$('.live-preview .price-tag').text($('.live-price').val() + " " + selectedOption); 
	});
		  
	
	//Add Asterisk on required filed
	
	$('input').each(function(){

		if($(this).attr('required') === 'required'){
			$(this).after('<span class="asterisk">*</span>');
		}

	});		  

});