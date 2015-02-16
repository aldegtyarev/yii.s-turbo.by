(function ($) {
    $(function () {
		
        $('.jcarousel-products-on-auto').jcarousel({
			wrap: 'circular',
			visible: 1
		});
		
		/*
		$('.jcarousel').jcarouselAutoscroll({
			interval: 3000,
			target: '+=1',
			autostart: true
		});
		*/

        $('.jcarousel-products-on-auto-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-products-on-auto-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
		/*

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination();
		*/
    });
})(jQuery);
