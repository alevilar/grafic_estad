<?php echo $this->Element('kpi_site_date_search');

if ( empty($sitio) ) {
	return;
}

?>

<h2 style="float: left; margin-right: 40px;"><?php echo $title_for_layout?></h2>

<div class="btn-toolbar pull-right">
<?php



foreach ($sitio['Sector'] as $sec ) {
	?>
	
		
			<div class="btn-group">
			<?php
			echo $this->Html->link('Sector '.$sec['name'], array(
				'action' => 'by_sector', $sec['id']),
				array(
					'class' => 'btn btn-primary'
				)
			);	
						
			foreach ($sec['Carrier'] as $car) {
				echo  $this->Html->link('Carrier '.$car['name'], array(
					'action' => 'by_carrier', $car['id']),
					array(
						'class' => 'btn'
					)
				);
			}
			?>
			</div>
		
	
	<?php
}

?>
</div>

<div class="clearfix"></div>

<?php 	
 		//$kpis = $this->Kpi->darVueltaKpiDate( $kpis );
       
?>
<table class="table table-bordered table-condensed table-kpis table-hover">
<?php
        $kpisDates = array_values( $days );
        $headers = array();
        // formatear la fecha
        foreach ($kpisDates  as $date ) {            
                $headers[] = date('d-m-y', strtotime($date));            
        }
        // colocar al inicio el texto        
        array_unshift( $headers, 'Kpis');                
        // colocar al final
        $headers[] = "AVG";

        echo $this->Kpi->tHead(  $headers );

        //$kpis = $this->Kpi->darVueltaKpiDate($kpis );
        
        
        $cels = array();
        foreach ($kpis as $k) {
            $row = array();
            $row[] = $k['Kpi']['name'];
            $avg = 0;
            $i = 0;
            foreach ($k['Day'] as $day) {
                $val = $day[0]['valor']; 
                if ($val){
                    $avg += $val;
                    $i++;
                }
                $class = $this->Kpi->thresholdEval($val, $k['Kpi']['sql_threshold_warning'],$k['Kpi']['sql_threshold_danger']);
                $ops['class'] = $class;
                $row[] = $this->Kpi->format_bg_class($val , $k['Kpi']['string_format'], $ops );
            }
            if ($i) {
                $val = $avg/$i;
                $class = $this->Kpi->thresholdEval($val, $k['Kpi']['sql_threshold_warning'],$k['Kpi']['sql_threshold_danger']);
                $ops['class'] = $class;
                $val = $this->Kpi->format_bg_class($val , $k['Kpi']['string_format'], $ops );
            } else {
                $val = '';
            }            
            $row[] = $val;
            $cels[] = $row;
        }
        echo  $this->Html->tableCells( $cels );
        //echo $this->Kpi->tCells( $kpis , 'arraysPorFieldNamesYAvg');       
?>

</table>
