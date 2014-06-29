

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


<div>

    <div class="span6">
        <h2 class="text-center"><?php echo $title_for_layout ?></h2>

       
        

        <?php
        if ( $this->layout == 'default') {
            echo $this->Element('kpi_site_date_search');
        }
        ?>

        <?php echo $this->element('btn_descargar_excel'); ?>
        <h4>Tabla de KPI´s</h4>
       <?php
        // KPI´s TABLE
        echo $this->element('kpis_table', array(
                'days' => $days,
                'kpis' => $kpiValues,
                'site_id' => null
            ));


        ?>

        
    </div>
    
    <div class="span6">
        <div class="well" style="margin-left: 10%">
            <h4 class="text-center">Detalle último mes por minuto</h4>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Puede hacer zoom arrastrando y soltando un intervalo dentro del gráfico</div>
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
</div>


<div class="clearfix"></div>
