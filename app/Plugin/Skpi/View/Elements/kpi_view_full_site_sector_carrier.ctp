<?php


$kpisDates = array_values($days);

$headers = array();
        // formatear la fecha
foreach ($kpisDates as $date) {
	
	$currDate = date('d-m-y', strtotime($date));
	if ( $currDate == date('d-m-y')) {
		$currDate = 'Hoy(parcial)';
	}
	$headers[] = $currDate;
}
        // colocar al inicio el texto        
array_unshift($headers, '&nbsp;');
$headers[] = 'AVG';


$cels = array();
foreach ($kpiValues as $kpv ) {
	$row = array(array($kpv['Title'][0], array('class' => $kpv['Title'][1] )));
	$i = $avg = 0;
	foreach ( $kpv['Day'] as $dv) {

		$val = $dv[0]['valor'];
		if ($val) {
			$avg += $val;
			$i++;
		}
		$class = $this->Kpi->thresholdEval($val, $dv['Kpi']['sql_threshold_warning'], $dv['Kpi']['sql_threshold_danger']);
		$ops['class'] = $class;
		$row[] = $this->Kpi->format_bg_class($val, $dv['Kpi']['string_format'], $ops);
	}

	if ($i) {
		$val = $avg / $i;
		$class = $this->Kpi->thresholdEval($val, $dv['Kpi']['sql_threshold_warning'], $dv['Kpi']['sql_threshold_danger']);
		$ops['class'] = $class;
		$val = $this->Kpi->format_bg_class($val, $dv['Kpi']['string_format'], $ops);
	} else {
		$val = '';
	}
	$row[] = $val;
	$cels[] = $row;

}

?>





<table class="table table-bordered table-condensed table-kpis table-hover">
	<?php

	echo $this->Kpi->tHead($headers);

	echo $this->Html->tableCells($cels);
	?>

</table>