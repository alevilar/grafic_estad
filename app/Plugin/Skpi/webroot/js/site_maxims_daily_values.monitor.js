
( function ($) {
    if ( typeof(ROTMS) == 'undefined' )  {
        // si no fue configurado antes, entonces colocarle un valor por defecto
        ROTMS = 7000;
    }

	var $radios = $('table.table-kpis input[type=radio]');
    var currRadio = $radios.length-1;
    var timeout;
    var pendinAjax; // ajax call
    var play = true;
    var $playBtn = $('button.play'  , '.controls');
    var $pauseBtn = $('button.pause', '.controls');

    initialize();

    function initialize () {
        $playBtn.hide(); // start hidden

        $playBtn.on('click', setPlay);
        $pauseBtn.on('click', setPause);
    
    }
    

    function abortar(){
    	if (pendinAjax) {
    		pendinAjax.abort();	
    	}
    }

    function setPlay() {
    	play = true;
    	// start
    	$playBtn.hide();
    	$pauseBtn.show();
    	mostrarDeA1Sitio();
    }


    function setPause(){
    	play = false;
    	// pause
    	abortar();
    	$pauseBtn.hide();
    	$playBtn.show();
    	clearTimeout(timeout);
    }

    
    
        
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
		
		var currRadioEl = $($radios[currRadio])[0];
        var $currRadio = $( $radios[currRadio] );
		if ( !$('#grafico').hasClass('span12') ) {
			// si no esta en modo full view, entonces scrollear porque el grafico es "fixed"
			currRadioEl.scrollIntoView( false );
		}

		$currRadio.prop('checked', true);
		$currRadio.change();
		$currRadio.parents('tr').siblings('.active').removeClass('active');
		$currRadio.parents('tr').addClass('active');
	}

	$radios.on('change', function ( ev ) {
		abortar();
		var url = $(ev.target).data('url');

        pendinAjax = null;
		pendinAjax = $.getJSON( url, function ( retObj ) {
            // remove childs elements
			$('#graph').empty();
            $('#site-link').empty();

            if (retObj && retObj.kpis && retObj.kpis.hasOwnProperty('0') && retObj.kpis[0].length) {
                createGraph('graph', retObj.kpis, retObj.title_for_layout);
            }
            // $('#site-link').html("");
            $('#site-link').html( retObj.sitio_link );

            if ( play ) {      
            	// solo hacerlo si esta activado el play, caso contrario seria pausa      	
            	mostrarDeA1Sitio();
            }            
		});
	});


	function mostrarDeA1Sitio (time) {
        if (!time){
            time = ROTMS;
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
