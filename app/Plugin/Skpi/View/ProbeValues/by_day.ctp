<?php
echo $this->Html->script(array(
    '/jqplot/jquery.jqplot.min',
//    '/jqplot/plugins/jqplot.dateAxisRenderer.min',
    '/jqplot/plugins/jqplot.barRenderer.min',
    '/jqplot/plugins/jqplot.categoryAxisRenderer.min',
    '/jqplot/plugins/jqplot.canvasTextRenderer.min',
    '/jqplot/plugins/jqplot.canvasAxisTickRenderer.min',
    '/jqplot/plugins/jqplot.pointLabels',
));
?>

<style type="text/css">
	.table th, .table td {
		text-align: center;
	}

	.table th.day-odd {
		border-top: #178e85 3px solid !important;
	}

	.table th.day-even {
		border-top: #b35900 3px solid !important;
	}
</style>


<?php

echo $this->element('kpi_site_date_search', array('modelName'=>'ProbeValue'));


$days = array();

foreach ($probeValues as $pb) {
	$dlvalues = $ulvalues = $ticks = array();
	$link = $this->Html->link($pb['Probe']['name'], array('plugin'=>'skpi', 'controller'=>'probes', 'action'=>'view', $pb['Probe']['id']));
	$cel = array( $link );

	foreach ($pb['ProbeValue'] as $pv) {
		$dName = strftime('%d %b', strtotime($pv[0]['date']));
		$days[$dName][$pv[0]['hour']] = $pv[0]['hour'];

		$tickDate = $dName . ', ' . $pv[0]['hour'].'hs';
		$ticks[] = $tickDate;

		$dl = round( $pv[0]['dl']/1024 * 100) / 100;
		$ul = round( $pv[0]['ul']/1024 * 100) / 100;
		$cel[] = $dl;
		$cel[] = $ul;

		$dlvalues[] = $dl;
		$ulvalues[] = $ul;

		

	}

	$cels[] = $cel;

	if ( !empty($dlvalues) || !empty($ulvalues) ) {
		echo $this->element('probes_bar_graph', array(
				'probe_id' => $pb['Probe']['id'],
				'probeName' => $pb['Probe']['name'],
				'dlvalues' => $dlvalues,
				'ulvalues' => $ulvalues,
				'ticks' => $ticks
				));
	} 

}

?>


<br>
<h1 style="text-align: center;">Tabla Resumen</h1>

<table class="table table-condensed">
	<thead>
		
		<tr>

			<th>&nbsp;</th>
			<?php
				$i = 0;
				foreach ( $days as $day => $hours ) {
					if ( $i++ % 2 == 0 ) {
						$clasname = 'day-odd';	
					} else {
						$clasname = 'day-even';
					}
					$colspan = count($hours) * 2;
					
					echo "<th colspan='$colspan' class='$clasname'>".$day."</th>";
				}
			?>

		</tr>
		<tr>
			<th>&nbsp;</th>
			<?php
				foreach ($days as $hours ) {
					foreach ($hours as $h ) {
						echo "<th colspan='2'>".$h."hs</th>";
					}
				}
			?>
		</tr>
			<th>Probe</th>
			<?php
				foreach ($days as $hours ) {
					foreach ($hours as $h ) {
						echo "<th>DL</th>";
						echo "<th>UL</th>";
					}
				}				
			?>
		<tr>

		</tr>
	</thead>

	<?php echo $this->Html->tableCells($cels); ?>

</table>


<style type="text/css">

.jqplot-point-label{
	font-size: 10px;
	}
.jqplot-axis{
	font-size: 10px;	
}
</style>

