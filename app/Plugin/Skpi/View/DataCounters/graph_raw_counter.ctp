<?php

echo $this->Html->script(array(

    '/jqplot/jquery.jqplot',
    '/jqplot/plugins/jqplot.dateAxisRenderer.min',
    '/jqplot/plugins/jqplot.pointLabels.min',
    //'/jqplot/plugins/jqplot.highlighter.min',
    '/jqplot/plugins/jqplot.cursor.min',


    '/skpi/flot/jquery.flot',
    '/skpi/flot/jquery.flot.time',
    '/skpi/flot/jquery.flot.selection',
	'/skpi/js/graphs/kpi_graph',


), true);


echo $this->Html->css('/jqplot/jquery.jqplot.min', true);
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->


<div>
	<div id="detail_graph_<?= $counter['Counter']['id']?>" style="height: 250px"></div>
	<div id="master_graph_<?= $counter['Counter']['id']?>" style="height: 100px"></div>
</div>


<script type="text/javascript">
	var data = <?= json_encode( $metrics, JSON_NUMERIC_CHECK); ?>;
 
    var dataDetail = [
            {
                label: "<?= $counter['Counter']['string_format'] ?>",
                data: data
            }
        ];

    var yaxisLabel = "<?= sprintf($counter['Counter']['string_format'], '')?>";
    var ops = {
    	'yaxisLabel' : yaxisLabel
    }

	$( function() {
		create_zomming_plot("#master_graph_<?= $counter['Counter']['id']?>", "#detail_graph_<?= $counter['Counter']['id']?>", dataDetail, ops);	
	});
</script>

<style>
	.axis-y-label{
		position: absolute;
		top: -20px;
		font-weight: bolder;
	}
</style>