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


<h1>Gráfico Matriz Mimo</h1>

<?php echo $this->element('search'); ?>

<div class="row-fluid">
    <div class="span6">
        <div id="mimo" style="height: 500px"></div>
    </div>
    <div class="span6">
        <div id="mimo_full" style="height: 500px"></div>
    </div>
</div>


<?php
$data = array();
$legend = array();
$mimos = array();
$mimosColor = array();
$mimoFecsColor = array();
foreach ($log_mstations as $l) {
    $name = $l['LogMstation']['mimo_id'] . " " . $l['DlFec']['modulation'];
    $legendName = "(" . $l[0]['cant'] . ") " . $name;
    $data[] = array($legendName, (int) $l[0]['cant']);
    
    if (!isset($mimos[$l['LogMstation']['mimo_id']])) {
        $mimos[$l['LogMstation']['mimo_id']] = 0;
        $mimosColor[] = $l['Mimo']['line_color'];
    }
    $mimos[$l['LogMstation']['mimo_id']] += $l[0]['cant'];
    
    // calculo el promedio
    $rgb = hex2rgb($l['DlFec']['line_color']);
    $rgb[0] = rgbRandom($rgb[0]);
    $rgb[1] = rgbRandom($rgb[1]);
    $rgb[2] = rgbRandom($rgb[2]);
    $mimoFecsColor[] = rgb2hex($rgb);
}
$mimos_a = array();
foreach ($mimos as $m=>$mv) {
    $mimos_a[] = array($m, $mv);
}
$mimos = $mimos_a;
?>

<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode($data) ?>;
        var dataMimo = <?php echo json_encode($mimos) ?>;
        var mimoCOlor = <?php echo json_encode($mimosColor) ?>;
        var mimoFecCOlor = <?php echo json_encode($mimoFecsColor) ?>;
console.debug(mimoFecCOlor);
        var plot1 = jQuery.jqplot('mimo_full', [data],
                {
                    title: {
                        text: 'Mimo y Modulación',
                        textColor: "rgb(102, 102, 102)",
                        fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                        fontSize: "19.2px",
                        textAlign: "center"
                    },
                    seriesColors: mimoFecCOlor,
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
                        show: true
                    }

                }
        );


        console.debug(dataMimo);

        var plot1 = jQuery.jqplot('mimo', [dataMimo],
                {
                    title: {
                        text: 'Mimo',
                        textColor: "rgb(102, 102, 102)",
                        fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                        fontSize: "19.2px",
                        textAlign: "center"
                    },
                    seriesColors: mimoCOlor,
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
                        show: true
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