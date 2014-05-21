
/**
*
*	Usa FLOP para graficar gráficos con ZOOM
*
**/
function create_zomming_plot ( domMasterContainerId, domDetailContainerId, data, options ) {

	if ( !$(domDetailContainerId).length ) {
		throw "Aun no esta cargado el contenedor detail";
	}

	if ( !$(domMasterContainerId).length ) {
		throw "Aun no esta cargado el contenedor master";
	}

	var axisLabel = '';
	function colocarAxisLabel() {
		if (options && options.hasOwnProperty('yaxisLabel')) {
			axisLabel = options.yaxisLabel;
			$(".flot-y-axis", domDetailContainerId).prepend("<span class='axis-y-label'>"+options.yaxisLabel+"</span>");
			$(".flot-y-axis", domMasterContainerId).css({visibility:'hidden'});
		}	
	}

		
	var tooltip = $('<div class="skytooltip">').appendTo($('body'));
	tooltip.hide();	
	
	 
	$(domDetailContainerId).on('plothover', function ( event, pos, item ) {
		
	    var ofsh, ofsw;
	    

	   if (item) {
			
//	 		$( ".selector" ).tooltip({ content: "Awesome title!" });
 // + item.series.label
 			  var date = new Date(item.series.data[item.dataIndex][0]);
 			
 			  var format = '';
 			  if ( options.yaxisLabel ) {
 			  	format = options.yaxisLabel;
 			  }
		      var content = item.series.data[item.dataIndex][1] + " "+ format + ", " + date.toLocaleString();

		      var wd = tooltip.width() / 2;

		      // $(domDetailContainerId).tooltip('show');
		      tooltip.css({
		      	top: (item.pageY-40) + 'px',
		      	left: (item.pageX - wd) + 'px',
		      })
				.text(content)
		      	.show('fade');
	 
	   } else {
	   	tooltip.hide();
	   }

	});



    var detailOptions = {   
    		grid: {
			    hoverable: true,
			    clickable: true,
			    mouseActiveRadius: 30  //specifies how far the mouse can activate an item
			},         
            series: {
                lines: { 
                	show: true, 
                	lineWidth: 3
                },
                points: { show: true },
                shadowSize: 0
            },           
            xaxis:{
                mode:"time",
                timezone: "America/Argentina/Buenos_Aires"                
            },
            selection:{
                mode: "x"
            }
    };

    var dataDetail = data;
 
 
 	if ( $(domDetailContainerId).length == 0 ) {
 		return;
 	}
 
    var plotDetail = $.plot( $(domDetailContainerId),
        dataDetail,
        detailOptions
    );
 

 	var masterOptions = {            
             series: {
                lines: { 
                	show: true, 
                	lineWidth: 3 
                },  
                shadowSize: 0
            },            
            xaxis:{
                mode:"time"
            },
            selection:{
                mode: "x"
            }
    };

    dataMain = [{
    	color: dataDetail[0].color,
    	data: dataDetail[0].data
    }];
    
    var plotMaster = $.plot($(domMasterContainerId),
        dataMain,
        masterOptions
    );
 

 	


    $(domDetailContainerId).bind("plotselected", function (event, ranges) {        
        plotDetail = $.plot($(domDetailContainerId), dataDetail,
                      $.extend(true, {}, detailOptions, {
                          xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to }
                      }));
         
        plotMaster.setSelection(ranges, true);
        colocarAxisLabel();
    });
 
    $(domMasterContainerId).bind("plotselected", function (event, ranges) {
        plotDetail.setSelection(ranges);
    });

    colocarAxisLabel();
}


function createGraph ( domContainerId, data, title ) {
		if (typeof(title) == 'undefined') {
			title = '';
		}
   		var plot = $.jqplot( 
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

		return plot;
   }






   function createMuchDataGraph ( domContainerId, data, title ) {
		if (typeof(title) == 'undefined') {
			title = '';
		}
   		var plot = $.jqplot( 
   						domContainerId, 
			        	data, 
			        	{
			        		seriesDefaults: {
				                showMarker:true, 
				                pointLabels:{ 
				                    show:false
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

		return plot;
   }