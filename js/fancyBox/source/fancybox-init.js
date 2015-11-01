$(document).ready(function () {
    'use strict';
    /*
    *  Simple image gallery. Uses default settings
    */

    //$('.fancybox').fancybox();
	
	$(".fancybox").fancybox({
		padding : 0,
		helpers: {
			overlay: {
				locked: false
			}
		}
	});

	$(".fancybox1").fancybox({
		padding : 20,
		helpers: {
			overlay: {
				locked: false
			}
		},
	});

    
});

