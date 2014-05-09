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
    '/jqplot/plugins/jqplot.dateAxisRenderer.min',
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

<span style="float: right" class="muted"><?php echo $textRefresh?></span>
<h1>Gráfico de Usuarios por Modulación</h1>

<?php 
echo $this->element('search'); 
$legend = $vals = array();
foreach ( $log_mstations as $k => $v ) {
    $legend[] = $k;
    $vals[] = $v;
}

?>

<div id="chart1" style="height: 600px"></div>


<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode($vals, JSON_NUMERIC_CHECK)?>;
        var dataColor = <?php echo json_encode($dataColor)?>;
        var labels = <?php echo json_encode($legend)?>;
        var plot1 = $.jqplot('chart1', data, {
          title: {
            text: 'Usuarios según Modulación',
            textColor: "rgb(102, 102, 102)",
            fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
            fontSize: "19.2px",
            textAlign: "center"
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
                  renderer:$.jqplot.DateAxisRenderer
              }
          },
          legend: {
              show: true,
              labels: <?php echo json_encode($legend)?>
          },
          series:[{lineWidth:4, markerOptions:{style:'square'}}]
        });
    });


    $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'pt-BR'
    });

    $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'pt-BR'
    });
</script>