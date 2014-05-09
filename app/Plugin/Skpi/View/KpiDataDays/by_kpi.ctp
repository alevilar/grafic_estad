<?php echo $this->Element('kpi_site_date_search', array('formAction'=>'by_kpi/'.$fieldName)); ?>

<h2 style="float: left; margin-right: 40px;"><?php echo $title_for_layout?></h2>

<div class="clearfix"></div>


<?php 


 		$kpis = $this->Kpi->darVueltaSiteDate( $kpis, $fieldName ); 		
       
?>
<table class="table table-bordered table-condensed table-kpis table-hover">
<?php
        $kpisDates = array_keys( $kpis );             
        array_unshift( $kpisDates, 'Sitio');        
        echo $this->Kpi->tHead( $kpisDates );


        $bySitio = array();
        
        foreach ($kpis as $date=>$n ) {        
            foreach ( $n as $sitId=>$sVal) {            	
            	$bySitio[$sitId][$date] = $this->Kpi->format_bg_class( $fieldName, $sVal['field_value'] );
            }            
        }

        $newnew = array();        
        foreach ($bySitio as $sitsId=>$sitval) {        	
        	array_unshift( $sitval, $this->Html->link($sites_list[$sitsId], array('action'=>'by_site', $sitsId)) );
        	$newnew[] = array_values( $sitval );
        }

        echo $this->Kpi->tCells( $newnew );
?>

</table>
