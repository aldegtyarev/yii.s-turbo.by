(function ($) {
    $(function () {
		
        $('.jcarousel-new-positions').jcarousel({
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

        $('.jcarousel-new-positions-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-new-positions-control-next')
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
