<?php

echo $this->element('kpi_site_date_search', array('modelName'=>'ProbeValue'));


$days = array();
foreach ($probeValues as $pb) {
	$link = $this->Html->link($pb['Probe']['name'], array('plugin'=>'skpi', 'controller'=>'probes', 'action'=>'view', $pb['Probe']['id']));
	$cel = array( $link );

	foreach ($pb['ProbeValue'] as $pv) {
		$cel[] = $pv[0]['dl'];
		$cel[] = $pv[0]['ul'];

		$dName = strftime('%a %d %b', strtotime($pv[0]['date']));
		$days[$dName][$pv[0]['hour']] = $pv[0]['hour'];
	}

	$cels[] = $cel;
}

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

