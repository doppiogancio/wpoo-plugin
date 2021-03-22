(function( $ ) {
	'use strict';

	$( window ).load(function() {
		jQuery('#start-xml-transform-script').click(function (e) {
			e.preventDefault();

			let data = {
				'action': 'start_script',
				'whatever': 1234
			};

			jQuery("#xml-transform-script-output").append(getCurrentDateTime() + " Started\n");

			jQuery.post(ajaxurl, data, function(response) {
				jQuery("#xml-transform-script-output").append(getCurrentDateTime() + " Ended\n");
			});
		})
	});
})( jQuery );

function getCurrentDateTime() {
	let now = new Date();
	return now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
}
