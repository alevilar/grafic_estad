


function createGraph ( domContainerId, data, title ) {
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