<?php
$this->start('head');
// hay que refrescar porque sino hay un memory leak por todos los ajax
$timeRefresh = 3600; // cada 1 hora refrescar la pagina
if ($timeRefresh) {
    echo "<meta http-equiv='refresh' content='$timeRefresh'>";
}

$this->end();

?>

<style type="text/css">
    .graph-wrapper .graph-fixed{
        position: fixed; 
        top: 200px; 
        width: 50%;
    }

    .jqplot-table-legend{
        top: -35px!important;
        right: 23px!important;   
    }


    .table-kpis td{
        text-align: center;

    }

    .table-kpis input{
        text-align: left;
        float: left;
    }

    .controls{
        position: absolute;    
        left: 48%;
        margin-top: -46px;    
    }

    .controls button.pause{
        font-size: 70%;
    }

    .controls button{
        width: 50px;
     
    }

    .btn-descargar-xls{
        position: absolute; 
        margin-left: 80px; 
        margin-top: 2px;
    }
</style>


<?php 

$this->start('search');
echo $this->Element('kpi_site_date_search', array('modelName' => 'SiteMaximsDailyValue')); 
$this->end();
?>



<div class="controls text-center">
    <div class="controls-wrap">
        <button class="play btn btn-primary">►</button>
        <button class="pause btn  btn-success">▐ ▌</button>
    </div>
    
</div>


        <?php 
        echo $this->Html->link(
            'Ver Toda la Red'
            , array(
                'controller'=>'data_days', 
                'action' => 'view_red'
                )
            , array('class' => 'btn btn-warning')
                );
        ?>

<div>

    <?php
    $spanTable = 'span6';
    $spanGraph = 'span6 graph-wrapper';
    if ( count($days) > 5 ) {
        $spanTable = 'span12';
        $spanGraph = 'span12';
    }
    ?>
    

    <div class="<?= $spanGraph?>" id="grafico">

        <div class="alert alert-info text-center">Los valores estan expresados en <i>Mbps</i></div>
        
        <div class="graph-fixed">
            <div id="graph"></div>
            <br>
            <div class="text-center" id="site-link"></div>
        </div>
    </div>



    <div class="<?= $spanTable?>">
        <?php 
        echo $this->element('btn_descargar_excel');
        
        echo $this->element('table_max_traf_x_sitio');
        ?>
    </div>

</div>



<?php $this->start('scriptBottom'); ?>

<?= $this->element('scroll_interval_to_js'); ?>

<script>
    var ROTMS = scrollInterval;
    var WWWROOT = "<?php echo $this->Html->url('/', true);?>";
</script>



<?php

echo $this->Html->script('/skpi/js/graphs/kpi_graph');
echo $this->Html->script('/skpi/js/site_maxims_daily_values.monitor');
echo $this->Html->css('/jqplot/jquery.jqplot.min');
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->

<?php
// debug($metrics);
echo $this->Html->script(array(
    '/jqplot/jquery.jqplot',
    '/jqplot/plugins/jqplot.dateAxisRenderer.min',
    '/jqplot/plugins/jqplot.pointLabels.min',
    '/jqplot/plugins/jqplot.canvasTextRenderer.min',
    '/jqplot/plugins/jqplot.canvasAxisTickRenderer.min',
    //'/jqplot/plugins/jqplot.highlighter.min',
    '/jqplot/plugins/jqplot.cursor.min',
));
?>

<?php $this->end() ?>