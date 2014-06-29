

<?php


$this->start('script');
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
    ));

    echo $this->Html->css('/jqplot/jquery.jqplot.min');
    echo $this->Html->css('/skpi/css/graphs');
?>
    <!--[if lt IE 9]>
    <?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
    <![endif]-->

    <style type="text/css">
        .btn-descargar-xls{
            float: right;
        }
    </style>
<?php
$this->end();
?>

<div class="probes view">
	<h2>Probe: <?php echo h($probe['Probe']['name']); ?></h2>
	<cite><?php echo h($probe['Probe']['description']); ?></cite>
</div>


<?php

	$dls = $uls = array();
	foreach ($probe['ProbeValue'] as $pv) {
		$datetime = strtotime($pv['date_time']);
		$dls[] = array($datetime, $pv['dl']);
		$uls[] = array($datetime, $pv['ul']);
	}

?>

<div>


<div class="related span6">
	<?php 


	echo $this->element(
	                'counter_zooming_view', array(
	                    'counter'=> $dlCounter, 
	                    'metrics' => $dls
	                    )
	                );
	?>
</div>


<div class="related span6">
	<?php

	echo $this->element(
	                'counter_zooming_view', array(
	                    'counter'=> $ulCounter, 
	                    'metrics' => $uls
	                    )
	                );
	?>
</div>

</div>