(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
 
	$(function() { 

		$(".alert").delay(4000).fadeOut(500);


		if ( $('#submitted_city') ) {
			var $cities;
			$cities = $('#submitted_city');
			$cities.on( 'change', function() {
					$.ajax({
					url: SEARCH_VARS.ajaxurl,
					method: 'GET',
					data: {
						action: 'get_neighborhoods',
						city: $cities.val(),
					},
					beforeSend: function() {
						jQuery("#ajaxloader").show();
						jQuery("#ajaxShadow").show();
					},
					success: function( data ) {
						if ( data.success ) {
							$('#submitted_district').html( data.data ); 
						}
						jQuery("#ajaxloader").hide();
						jQuery("#ajaxShadow").hide();
					}
				})
			} );
		}


		$('#annoces_slider').owlCarousel({
			loop:true,
			margin: 30,
			dots: false, 
			nav:true,	
			items:3,
			navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				} ,
				1000:{
					items:3
				} 
			}
		});


		
		$('#prev_first_step').click(function(event){
			event.preventDefault();
			$('.step.first_step').slideDown(); 
			$('.step.second_step').slideUp();  
		});
		
		$('#next_second_step').click(function(event){
			event.preventDefault();
			$('.step.first_step').slideUp(); 
			$('.step.second_step').slideDown();  
		});
	
		$('#prev_second_step').click(function(event){
			event.preventDefault();
			$('.step.second_step').slideDown();  
			$('.step.third_step').slideUp();  
		});
	
		$('#next_third_step').click(function(event){
			event.preventDefault(); 
			$('.step.second_step').slideUp();  
			$('.step.third_step').slideDown(); 
		});

	});

	


})( jQuery );

function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase

	number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
	var n = !isFinite(+number) ? 0 : +number
	var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
	var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	var s = ''

	var toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec)
		return '' + (Math.round(n * k) / k)
		.toFixed(prec)
	}

	// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || ''
		s[1] += new Array(prec - s[1].length + 1).join('0')
	}

	return s.join(dec)
}