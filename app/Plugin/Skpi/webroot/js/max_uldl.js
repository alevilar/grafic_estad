
( function ($) {

	var $radios = $('table.table-kpis input[type=radio]');

	$radios.on('change', function ( ev ) {

		var url = WWWROOT + 'skpi/kpi_data_days/graf_max_uldl_de_sitio/' + ev.target.value;

		$.getJSON( url, function ( retObj) {
			$('#graph').html("");
			$('#site-link').html( retObj.sitio_link );
			createGraph('graph', retObj.kpis, retObj.title_for_layout);			
		});
	});


	var currRadio = $radios.length-1;
	

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

	


	function mostrarDeA1Sitio () {
		var interval =  setInterval( function(){					
			changeRadio();
		}, 7000);	
		return interval;
	}



	// Init functions
	timeout = mostrarDeA1Sitio();


	$radios.on('click', function ( ev ) {
	
		$.each( $radios, function( index, radio ) {			
				if ( radio == ev.target ) {					
					currRadio = index;
					changeRadio(currRadio);
					clearInterval(timeout);

					setTimeout(function(){
						timeout = mostrarDeA1Sitio();
					},28000);
					return;
				}
		} );

		
	});



	changeRadio( 0 );



}(jQuery));
