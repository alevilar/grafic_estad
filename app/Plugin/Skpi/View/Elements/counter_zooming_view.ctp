<?php

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


), true);


echo $this->Html->css('/jqplot/jquery.jqplot.min', true);

?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->


<div id="detail_graph_<?= $counter['Counter']['id']?>" style="height: 250px"></div>
<div id="master_graph_<?= $counter['Counter']['id']?>" style="height: 100px"></div>


<script type="text/javascript">
    ( function ( ) {
        var data = <?= json_encode( $metrics, JSON_NUMERIC_CHECK); ?>;
        var dataDetail = [
                {
                    label: "<?= $counter['Counter']['name']?>",
                    data: data,
                    color: "<?= empty($counter['Counter']['color'])? '': $counter['Counter']['color'] ?>"
                }
            ];

        var yaxisLabel = "<?= sprintf( $counter['Counter']['string_format'], ''); ?>";
        var ops = {
            'yaxisLabel' : yaxisLabel
        }

        $( function() {
            create_zomming_plot("#master_graph_<?= $counter['Counter']['id']?>", "#detail_graph_<?= $counter['Counter']['id']?>", dataDetail, ops);   
        });    
    })();
    
</script>