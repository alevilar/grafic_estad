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
    '/jqplot/jquery.jqplot',
    '/jqplot/plugins/jqplot.dateAxisRenderer',
    '/jqplot/plugins/jqplot.pointLabels.min',
//        '/jqplot/plugins/jqplot.canvasTextRenderer.min',
    '/jqplot/plugins/jqplot.highlighter.min',
    '/jqplot/plugins/jqplot.cursor.min',
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
<table class="table">
    <thead>
        <tr>
            <?php
            foreach ($todasfechas as $f) {
                echo "<th>".date('d M',strtotime($f))."</th>";
            }
            ?>
            <th></th>
        </tr>
    </thead>
    <tr>
        <?php
        foreach ($todasfechas as $f) {
            echo "<td>&nbsp;";
            echo array_key_exists($f,$fechas) ? $fechas[$f] : '';
            echo "</td>";
        }
        ?>
    </tr>
</table>


<div id="chart1" style="height: 600px"></div>


<style type="text/css">
   
    #chart1 .jqplot-point-label {
        font-size: 12px;
    }    
    
    table.jqplot-table-legend, table.jqplot-cursor-legend{
        margin-top: -105px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode($vals, JSON_NUMERIC_CHECK) ?>;
        var dataColor = <?php echo json_encode($dataColor) ?>;
        var legends = <?php echo json_encode($legend); ?>;
        var fechaDesde = '<?php echo date('Y-m-d', strtotime($fechaDesde)); ?>';
        var fechaHasta = '<?php echo date('Y-m-d', strtotime($fechaHasta)); ?>';
       
        var plot1 = $.jqplot('chart1', data, {
            title: {
                text: 'Max. Cant. de Usuarios según Modulación',
                textColor: "rgb(102, 102, 102)",
                fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                fontSize: "19.2px",
                textAlign: "center"
            },
            seriesDefaults: {
                showMarker:true, 
                pointLabels:{ 
                    show:true,
                    location:'nw', 
                    ypadding:3,
                    stackedValue: true
                },
                renderer: $.jqplot.BarRenderer,
                rendererOptions:{barMargin: 25}, 
            },
            seriesColors: dataColor,
            highlighter: {
                show: true,
                sizeAdjust: 7.5
              },
              cursor: {
                show: false
              },
            axes:{
              xaxis:{                  
                  min: fechaDesde,
                  max: fechaHasta,
                  renderer:$.jqplot.DateAxisRenderer,
                  tickInterval: '1 day',
                  tickOptions: {
                        formatString: '%#d&nbsp;%b' //formato de la fecha
                  }
              }
          },
            legend: {
                show: true,
                labels: legends
            }
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