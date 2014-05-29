<div class="text-center">

	<?php
	if (empty($metricsDl) || empty($metricsUl)) {
		?>
		<div class="alert alert warning">No se registran datos</div>
		<?php
		return;
	}
	?>

	<div id="graph"></div>
	<br>
	<?php


	echo $this->Html->link(
	         'Ver Kpi´s de '.$site['Site']['name'], 
	         array(
	             'controller' => 'data_days',
	             'action' => 'view', 
	             'site',
	             $site['Site']['id']), 
	         array(
	             'class' => 'btn btn-large btn-success'
	             ));
	?>
</div>

<script>
    var WWWROOT = "<?php echo $this->Html->url('/', true);?>";
</script>
<?php

echo $this->Html->script('/skpi/js/graphs/kpi_graph');
echo $this->Html->css('/jqplot/jquery.jqplot.min');
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->

<?php
// debug($metrics);
echo $this->Html->script(array(
    '/jqplot/jquery.jqplot',
    '/jqplot/plugins/jqplot.dateAxisRenderer.min',
    '/jqplot/plugins/jqplot.pointLabels.min',
    //'/jqplot/plugins/jqplot.highlighter.min',
    '/jqplot/plugins/jqplot.cursor.min',



));

?>

<script>
     var kpis = <?php echo json_encode(array( $metricsDl, $metricsUl  ), JSON_NUMERIC_CHECK)?>;
     
     createGraph('graph', kpis, "<?php echo $title_for_layout?>");
</script>
