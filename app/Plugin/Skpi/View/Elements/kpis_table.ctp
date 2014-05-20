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
array_unshift($headers, 'Kpis');
// colocar al final
$headers[] = "AVG";


$cels = array();
foreach ($kpis as $k) {
    $row = array();
    $row[] = $this->Html->link($k['Kpi']['name'], array(
        'controller' => 'data_days',
        'action' =>'site_kpi_detail',
        $site_id,
        $k['Kpi']['id']
        ));
    $avg = 0;
    $i = 0;
    foreach ($k['Day'] as $day) {
        $val = $day[0]['valor'];
        if ($val) {
            $avg += $val;
            $i++;
        }
        $class = $this->Kpi->thresholdEval($val, $k['Kpi']['sql_threshold_warning'], $k['Kpi']['sql_threshold_danger']);
        $ops['class'] = $class;
        $row[] = $this->Kpi->format_bg_class($val, $k['Kpi']['string_format'], $ops);
    }
    if ($i) {
        $val = $avg / $i;
        $class = $this->Kpi->thresholdEval($val, $k['Kpi']['sql_threshold_warning'], $k['Kpi']['sql_threshold_danger']);
        $ops['class'] = $class;
        $val = $this->Kpi->format_bg_class($val, $k['Kpi']['string_format'], $ops);
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
//echo $this->Kpi->tCells( $kpis , 'arraysPorFieldNamesYAvg');       
?>

</table>
