
( function ($) {

	var $radios = $('table.table-kpis input[type=radio]');
        var currRadio = $radios.length-1;
        var timeout;
        
        function changeRadio ( index ) {
		if ( index ) {			
			currRadio = index;			
		} else {
			// voy al siguiente
			if ( currRadio == $radios.length-1 ) {
					currRadio = -1;
			}
			currRadio++;	
		}
		
		$($radios[currRadio]).prop('checked', true);
		$($radios[currRadio]).change();
		$($radios[currRadio]).parents('tr').siblings('.active').removeClass('active');
		$($radios[currRadio]).parents('tr').addClass('active');
	}

	$radios.on('change', function ( ev ) {

		var url = WWWROOT + 'skpi/kpi_data_days/graf_max_uldl_de_sitio/' + ev.target.value;

		$.getJSON( url, function ( retObj) {
			$('#graph').html("");
                        if (retObj && retObj.kpis && retObj.kpis[0].length) {
                            createGraph('graph', retObj.kpis, retObj.title_for_layout);
                        }
                        mostrarDeA1Sitio();
		});
	});


	function mostrarDeA1Sitio (time) {
                if (!time){
                    time = 7000;
                }
                clearTimeout(timeout);
		timeout =  setTimeout( function(){					
			changeRadio();
		}, time);
	}




	$radios.on('click', function ( ev ) {
	
		$.each( $radios, function( index, radio ) {			
				if ( radio == ev.target ) {					
					changeRadio(index);					
					return;
				}
		} );

		
	});



	changeRadio( 0 );



}(jQuery));
