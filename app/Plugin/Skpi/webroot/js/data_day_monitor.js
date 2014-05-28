
(function($) {   

    var containerDivSIteName = '#container-info-site-';

    var currContainer = null;

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


        

        var ajaxRequest = null;


        function bringToEarh ( event ) {
            $(event.target).addClass('blink');

            if ( ajaxRequest ) {
                ajaxRequest.abort();
            }
            var href = $('a', event.target).attr('href');

            var promise = $.get( href )
                            .done(function( data ){               
                                toggleDisplay('show', event);
                                var siteId = $('a',event.target).data('siteId');
                                currContainer = $( containerDivSIteName+siteId );
                                currContainer.html(data);

                                $(event.target).addClass('active');
                                $(event.target).removeClass('blink');
                            });
            ajaxRequest = promise;
            return promise;
        }


        function toggleDisplay( what ,event ) {                  
            var siteId = $('a',event.target).data('siteId');
            currContainer = $( containerDivSIteName+siteId );

            if ( what == 'show' ) {
                currContainer.show('slide', { direction: "top" }, "slow" );
            } else {
                currContainer.hide("drop", { direction: "down" }, "slow" );
            }
        }


        
        $('.jcarousel').on('jcarousel:targetin', 'li', bringToEarh);  

        $('.jcarousel li:first').trigger('jcarousel:targetin' );

		$('.jcarousel').on('jcarousel:targetout', 'li', function(ev, carousel) {
		    $(this).removeClass('active');
            toggleDisplay('hide', ev);

            $('.counter-detail', currContainer ).trigger('plotchangeview');
		});


        $('.jcarousel').on('click', 'a', function ( ev ) {
            $('.jcarousel').jcarousel('scroll', $(this).parent());
            return false;
        });
		


    
})(jQuery);
