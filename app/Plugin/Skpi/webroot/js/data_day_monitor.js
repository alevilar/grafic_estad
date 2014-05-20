
(function($) {   

        $('.jcarousel').jcarousel({
            wrap: 'circular',
            center: true,
            transitions: true
        });

        $('.jcarousel').jcarouselAutoscroll({
		    interval: scrollInterval
		});


        $('.jcarousel-control-prev').jcarouselControl({
            target: '-=1'
        });

        $('.jcarousel-control-next').jcarouselControl({
            target: '+=1'
        });


        $('.jcarousel').on('click', 'a', function ( ev ) {
		    $('.jcarousel').jcarousel('scroll', ev.target);
		});

        
        $('.jcarousel').on('jcarousel:targetin', 'li', function() {
		    $(this).addClass('active');
		});

		$('.jcarousel').on('jcarousel:targetout', 'li', function(event, carousel) {
		    $(this).removeClass('active');
		});
		
    
})(jQuery);
