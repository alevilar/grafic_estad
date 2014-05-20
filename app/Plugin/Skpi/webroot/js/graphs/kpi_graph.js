
/**
*
*	Usa FLOP para graficar gráficos con ZOOM
*
**/
function create_zomming_plot ( domMasterContainerId, domDetailContainerId, data, options ) {

	function colocarAxisLabel() {
		if (options && options.hasOwnProperty('yaxisLabel')) {
			$("#detail_graph .flot-y-axis").prepend("<span class='axis-y-label'>"+options.yaxisLabel+"</span>")
		}	
	}


    var detailOptions = {            
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
 
    
 
    var plotDetail = $.plot($(domDetailContainerId),
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
    console.debug(dataDetail);
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