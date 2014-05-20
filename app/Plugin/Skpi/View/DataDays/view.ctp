

<?php

?>
<div>
    <div class="span6">
        <?php echo $this->element(
            'counter_zooming_view', array(
                'counter'=>$metricsDl['Counter'], 
                'metrics' => $metricsDl['DataCounter']
                )
            );
        ?>

        <?php echo $this->element('counter_zooming_view', array('counter'=>$metricsUl['Counter'], 'metrics' => $metricsUl['DataCounter']));?>

    </div>

    <div class="span6">

        <?php echo $this->element('Skpi.sitio_sectores_y_carriers') ?>
        
        <?php
        // KPI´s TABLE
        echo $this->element('kpis_table', array(
                'days' => $days,
                'kpis' => $kpis,
                'site_id' => $site['Site']['id']
            ));


        if ( $this->layout == 'default') {
            echo $this->Element('kpi_site_date_search');
        }

        ?>

        
    </div>
    
</div>


<div class="clearfix"></div>





<style>
    .axis-y-label{
        position: absolute;
        top: -20px;
        font-weight: bolder;
    }
</style>