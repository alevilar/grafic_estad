<?php
$this->start('head');
$textRefresh = '';
$timeRefresh = Configure::read('Sky.refreshTime');
if ($timeRefresh) {
    echo "<meta http-equiv='refresh' content='$timeRefresh'>";
    $textRefresh = "Esta página se refresca automáticamente cada $timeRefresh segundos";
}

$this->end();




echo $this->Html->script('/bootstrap_datetimepicker/js/bootstrap-datetimepicker.min');
echo $this->Html->css('/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min');
echo $this->Html->css('/jqplot/jquery.jqplot.min');
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->

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


<style>
    select{
        width: 100%;
    }

    input{
        width: 100%;
    }

    .date input{
        width: auto;
    }

    .bootstrap-datetimepicker-widget{
        top: 400px;
    }
</style>

<span style="float: right" class="muted"><?php echo $textRefresh ?></span>
<h1>Gráfico de Usuarios por Modulación</h1>



<?php
echo $this->Form->create('LogMstation', array(
    'type' => 'get',
    'class' => 'form',
    ));
?>
<div class="well">
    <div class="span2">
        <?php
        
        
        echo $this->Form->input('datetime_from', array(
          //  'class' => 'icon icon-calendar',
            'label' => 'Desde',
            'after' => '<span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>',
            'div' => array(
                'id' => 'datetimepicker1',
                'class' => 'input-append date',
            )
            ));
        echo "<div class=''clearfix></div>";
        
        echo $this->Form->input('datetime_to', array( 
            'label' => 'Hasta',
            'after' => '<span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>',
            'div' => array(
                'id' => 'datetimepicker2',
                'class' => 'input-append date',
            )
            ));
        ?>
    </div>    
    <div class="span2 offset1">
        <br><br><br>
        <?php
        echo $this->Form->button('Buscar', array('type'=>'submit', 'class'=>'btn btn-large btn-primary'));
        ?>
    </div>
    <div class="clearfix"></div>
</div>    
<?php
echo $this->Form->end();
?>

<div class="clearfix"></div>


<?php
//echo $this->element('search');
$legend = $vals = array();
foreach ($log_mstations as $k => $v) {
    $legend[] = $k;
    $vals[] = $v;
}
?>

<div id="chart1" style="height: 600px"></div>


<style type="text/css">
   
    #chart1 .jqplot-point-label {
        font-size: 16pt;
    }    
    
    table.jqplot-table-legend, table.jqplot-cursor-legend{
        margin-top: -95px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode($vals, JSON_NUMERIC_CHECK) ?>;
        var sumaTotales = <?php echo json_encode($sumasTotales, JSON_NUMERIC_CHECK) ?>;
        var ticks = <?php echo json_encode($aFechas) ?>;
        var dataColor = <?php echo json_encode($dataColor) ?>;
        var legends = <?php echo json_encode($legend); ?>;
        var fechaDesde = '<?php echo date('Y-m-d', strtotime($fechaDesde)); ?>';
        var fechaHasta = '<?php echo date('Y-m-d', strtotime($fechaHasta)); ?>';
        var labels64 = <?php echo json_encode($labels['64QAM']) ?>;
        var labels16 = <?php echo json_encode($labels['16QAM']) ?>;
        var labelsqpsk = <?php echo json_encode($labels['QPSK']) ?>;
        data.push(sumaTotales);
        dataColor.push("#848484");
        legends.push('Totales');
        
        data = [labelsqpsk, labels16, labels64, sumaTotales];

        var plot1 = $.jqplot('chart1', data, {
            title: {
                text: 'Max. Cant. de Usuarios según Modulación',
                textColor: "rgb(102, 102, 102)",
                fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                fontSize: "26px",
                textAlign: "center"
            },
            stackSeries: true,
            seriesColors: dataColor,
            seriesDefaults: {
                fill: true,
                renderer: $.jqplot.BarRenderer,
                rendererOptions: {
                    fillToZero: true,
                    varyBarColor: true
                },
//                rendererOptions:{
//                    barMargin: 25
//                }, 
                pointLabels: {
                    show: true,
                    edgeTolerance: 5,
//                    stackedValue: true,
                    location: 's',
//                    ypadding:3
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks                    
                },
                x2axis: {
                    renderer: $.jqplot.CategoryAxisRenderer
                },
                yaxis: {
                    autoscale: true,
                    pad: 0,
//                    max: 100
                },
                y2axis: {
                    autoscale: true,
//                    pad: 0
                }
            },
            legend: {
                show: true,
                labels: legends
            },
            series: [
                {
                    pointLabels: {
                        show: true,
                        location: 'w',
                        legend: labelsqpsk,
                        formatString: function(){return '%s%';}()
                    }
                },
                {
                    pointLabels: {
                        show: true,
                        location: 'w',
                        legend: labels16,
                        formatString: function(){return '%s%';}()
                    }
                },
                {
                    pointLabels: {
                        show: true,
                        location: 'w',
                        legend: labels64,
                        formatString: function(){return '%s%';}()
                    }
                },
                {
                    renderer: $.jqplot.LineRenderer,
                    xaxis: 'xaxis',
                    yaxis: 'y2axis',
                    fill: false,
                    pointLabels: {
                        show: true,
                        stackedValue: true,
                        location: 'ne',
                        ypadding: 10
                    }
                }
            ]
        });
    });


    $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd',
        language: 'es-ES'
    });

    $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd',
        language: 'es-ES'
    });
</script>