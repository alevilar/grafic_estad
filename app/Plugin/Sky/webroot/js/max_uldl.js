
( function ($) {

	var $radios = $('table.table-kpis input[type=radio]');
	var $graficoContainer = $('#grafico');



			           
	var createGraph = function( domContainerId, data, title ) {
   		var plot1 = $.jqplot( 
   						domContainerId, 
			        	data, 
			        	{
			        		seriesDefaults: {
				                showMarker:true, 
				                pointLabels:{ 
				                    show:true,
				                    location:'nw', 
				                    ypadding:3,
				                    stackedValue: true
				                },				               
				                rendererOptions:{barMargin: 25}
				            },
					        title: {
					            text: title,
					            textColor: "rgb(102, 102, 102)",
					            fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
					            fontSize: "19.2px",
					            textAlign: "center"
					        },
				        	legend: {
				                show: true,
				                labels: ['UL', 'DL']
				            },
				        
				          cursor: {
				            show: false
				          },
				          gridPadding:{right:35},
				          axes:{
					        xaxis:{
					          renderer:$.jqplot.DateAxisRenderer, 
					          tickOptions:{formatString:'%b %#d'},					        
					          tickInterval:'1 day',
					          pad: 0
					        },
					        yaxis: {
							    autoscale:true
							}
					      },				          
				          series:[{lineWidth:4, markerOptions:{style:'square'}}]
						}
		);
   }




	$radios.on('change', function ( ev ) {

		var url = WWWROOT + 'sky/date_kpis/graf_max_uldl_de_sitio/' + ev.target.value;
		//$graficoContainer.load( );

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
