(function($) {
	$(document).ready(function() {

		$('[class^="datepicker"]').pickadate({
          	min: true,
			onSet: function() {

				var $start = $('.datepicker1').pickadate(),
					startPicker = $start.pickadate('picker'),
					startDate = startPicker.get('select');
					startDatePick = startDate['pick'];
					startDateVal = startPicker.get('value');

				var $end = $('.datepicker2').pickadate(),
					endPicker = $end.pickadate('picker'),
					endDate = endPicker.get('select');
					endDatePick = endDate['pick'],
					endDateVal = endPicker.get('value'),
					product_id = $('.datepicker2').data('product_id');

				var interval = parseInt( (endDatePick - startDatePick) / 86400000 );

				$('.datepicker1').attr('data-value', startDateVal);
				$('.datepicker2').attr('data-value', endDateVal);

				var startIsSet = $('.datepicker1').attr('data-value'),
					endIsSet = $('.datepicker2').attr('data-value');

				if ( interval == 0 ) {
					interval = 1;
				}

				var data = {
					action: 'add_new_price',
					product_id: product_id,
					days: interval,
					start: startDateVal,
					end: endDateVal
				};

				var this_page = window.location.toString();

				if ( startIsSet == '' || endIsSet == '' ) {
					return;
				}

				if ( startIsSet != '' && endIsSet != '' ) {

					$('form.cart').fadeTo('400', '0.6').block({message: null, overlayCSS: {background: 'transparent url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } } );

					$.post(ajax_object.ajax_url, data, function( response ) {

						$('.woocommerce-error, .woocommerce-message').remove();
						fragments = response.fragments;
						errors = response.errors;

						if ( errors ) {
							$.each(errors, function(key, value) {
								$(key).replaceWith(value);
							});
						}

						if ( fragments ) {
							$.each(fragments, function(key, value) {
								$(key).replaceWith(value);
							});
						}

						// Unblock
						$('form.cart').stop(true).css('opacity', '1').unblock();
					
					});

				}

			}

		});

		

	});
})(jQuery);
