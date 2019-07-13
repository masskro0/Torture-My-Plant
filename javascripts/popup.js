// Script for the confirmation popup. Uses jquery library

jQuery(document).ready(function($){
    
	// Open popup
	$('.confirmation-popup').on('click', function(event){
		event.preventDefault();
		$('.popup').addClass('is-visible');
	});
	
	// Close popup
	$('.popup').on('click', function(event){
		if( $(event.target).is('.popup-close') || $(event.target).is('.popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
    
	// Close popup when the user hits the ESC button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.popup').removeClass('is-visible');
	    }
    });
});