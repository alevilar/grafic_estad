<p>
<?php

$dom_probe_id = "chart-probe-$probe_id";

?>


<div id="<?php echo $dom_probe_id ?>"></div>


<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode( array( $dlvalues, $ulvalues), JSON_NUMERIC_CHECK) ?>;
        var ticks = <?php echo json_encode($ticks) ?>;


        var plot1 = $.jqplot('<?php echo $dom_probe_id?>', data, {

        	title: {
                text: '<?php echo $probeName?>',
                textColor: "rgb(102, 102, 102)",
                fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                fontSize: "26px",
                textAlign: "center"
            },

            seriesColors: ['#0174DF','#01DF74'],

	        // The "seriesDefaults" option is an options object that will
	        // be applied to all series in the chart.
	        seriesDefaults:{
	            renderer:$.jqplot.BarRenderer,
	            rendererOptions: {
	            	fillToZero: true,
	            	barPadding: 1,      // number of pixels between adjacent bars in the same group (same category or bin).
		            barMargin: 40,      // number of pixels between adjacent groups of bars.
		            barDirection: 'vertical', // vertical or horizontal.
		            barWidth: null,     // width of the bars.  null to calculate automatically.
		            shadowOffset: 0,    // offset from the bar edge to stroke the shadow.
		            shadowDepth: 0,     // nuber of strokes to make for the shadow.
		            shadowAlpha: 0,   // transparency of the shadow.
	            },

	            pointLabels: {
                    show: true,
                    edgeTolerance: -10,
//                    stackedValue: true,
                    location: 'n',
                    ypadding:-2
                }
	        },
	        // Custom labels for the series are specified with the "label"
	        // option on the series option.  Here a series option object
	        // is specified for each series.
	        series:[
	            {label:'DL'},
	            {label:'UL'}
	        ],
	        // Show the legend and put it outside the grid, but inside the
	        // plot container, shrinking the grid to accomodate the legend.
	        // A value of "outside" would not shrink the grid and allow
	        // the legend to overflow the container.
	        // legend: {
	        //     show: false,
	        //     placement: 'outsideGrid'
	        // },

	        axes: {
	            // Use a category axis on the x axis and use our custom ticks.
	            xaxis: {
	                renderer: $.jqplot.CategoryAxisRenderer,
	                ticks: ticks
	            },
	            // Pad the y axis just a little so bars can get close to, but
	            // not touch, the grid boundaries.  1.2 is the default padding.
	            yaxis: {
	                pad: 1.05
	            }
	        },


	        axesDefaults: {
		        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
		        tickOptions: {		          
		          fontSize: '8pt',
		          angle: -30
		        }
		    }
		   
    });


    });

</script>
</p>