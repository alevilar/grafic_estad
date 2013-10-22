<?php 

$this->start('head'); 
$textRefresh = '';
$timeRefresh = Configure::read('Sky.refreshTime'); 
if ($timeRefresh) {
    echo "<meta http-equiv='refresh' content='$timeRefresh'>";
    $textRefresh = "Esta página se refresca automáticamente cada $timeRefresh segundos";
}
?>
<style>
    .legend_box{
        float: right;
    }
    
    .legend_box .cuadradito{
       float: left;
       width: 15px;
       height: 15px;
       border: 1px solid grey;
       margin-right: 3px;
       outline-color: red;
    }
    
    .legend_box .modulation{
        float: left;
        margin-right: 20px;
    }
</style>

<?php $this->end(); ?>

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

<span style="float: right" class="muted"><?php echo $textRefresh?></span>
<h1>Gráfico de Modulaciones Por Sitio</h1>


<div class="well">
<?php
echo $this->Form->create('LogMstation', array(
    'type' => 'get',
    'style' => 'margin: 0px;'
    ));
?>
        <?php
        echo $this->Form->input('datetime', array( 
            'div' => false,
            'label' => false,
            'empty' => 'Seleccione',
            'onchange' => 'this.form.submit();',
            'style' => 'float: left; width: 200px !important; margin-right: 30px;',
            ));        
        ?>
        
<div class="legend_box">
            <?php 
            foreach ($dl_fecs as $dlMod=>$dlColor) {
                echo "<div class='cuadradito' style='background-color: $dlColor'></div><span class='modulation'>$dlMod</span>";
            }
            ?>
        </div>
    <div class="clearfix"></div>
<?php
echo $this->Form->end();
?>

    </div>


<div class="clearfix"></div>

    <?php
    foreach ($log_mstations as $sId => $lms) {
        if (empty($lms['DlFec'])) {
            continue;
        }
        ?>
        <div style="width: 20%; float: left">
            <div id="<?php echo "chart_$sId" ?>" style="height: 200px"></div>
        </div>
        <?php
    }
    ?>
<div class="clearfix"></div>

<?php
foreach ($log_mstations as $siteId => $lms) {
    $data = array();
    $dataColor = array();
    $legend = array();
    if (empty($lms['DlFec'])) {
        continue;
    }
    foreach ($lms['DlFec'] as $l) {
        $data[] = array($l['modulation'], (int) $l['cant']);
        $dataColor[] = $l['line_color'];
        $legend[] = "(" . $l['cant'] . ") " . $l['modulation'];
    }
    ?>

    <script type="text/javascript">

        $(document).ready(function() {
            var data = <?php echo json_encode($data) ?>;
            var dataColor = <?php echo json_encode($dataColor); ?>;
            var plot1 = jQuery.jqplot('<?php echo "chart_$siteId" ?>', [data],
                    {
                        title: {
                            text: '<?php echo $lms['Site']['name'] ?>',
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
                            show: false
                        }

                    }
            );
        });
    </script>

    <?php
}
?>



<script>
    $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'pt-BR'
    });

    $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'pt-BR'
    });
</script>