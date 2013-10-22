<?php
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
    '/jqplot/plugins/jqplot.pieRenderer.min',
    '/jqplot/plugins/jqplot.donutRenderer.min',
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


<h1>Gráfico de Modulaciones</h1>

<?php echo $this->element('search'); ?>

<div id="chart1" style="height: 600px"></div>

<?php
    $data = array();
    $dataColor = array();
    $legend = array();
    foreach ( $log_mstations as $l) {
        $data[] = array($l['DlFec']['modulation'], (int) $l[0]['cant']);
        $dataColor[] = $l['DlFec']['line_color'];
        $legend[] = "(" . $l[0]['cant'].") ". $l['DlFec']['modulation'];
    }
?>

<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode($data)?>;
        var dataColor = <?php echo json_encode($dataColor); ?>;
        var plot1 = jQuery.jqplot('chart1', [data],
                {
                    title: {
                        text: 'Modulación',
                        textColor: "rgb(102, 102, 102)",
                        fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                        fontSize: "19.2px",
                        textAlign: "center"
                    },
                    seriesColors: dataColor,
                    seriesDefaults: {                        
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {                            
                            // Put data labels on the pie slices.
                            // By default, labels show the percentage of the slice.
                            showDataLabels: true
                        }
                    },
                    legend: {
                        show: true,
                        labels: <?php echo json_encode($legend)?>
                    }
                    
                }
        );
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