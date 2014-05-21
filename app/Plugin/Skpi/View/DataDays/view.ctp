

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
<?php
$this->end();
?>


<div>

    <div class="span6">
        <h2 class="text-center"><?php echo $title_for_layout ?></h2>

        <div style="margin: auto;"><?php echo $this->element('Skpi.sitio_sectores_y_carriers') ?></div>
        
        <?php

        // KPI´s TABLE
        echo $this->element('kpis_table', array(
                'days' => $days,
                'kpis' => $kpiValues,
                'site_id' => $site['Site']['id']
            ));


        if ( $this->layout == 'default') {
            echo $this->Element('kpi_site_date_search');
        }

        ?>

        
    </div>
    
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
</div>


<div class="clearfix"></div>
