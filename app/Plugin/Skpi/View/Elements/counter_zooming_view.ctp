

<?php

if ( $this->layout != 'ajax' ) {
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
    ?>

    <!--[if lt IE 9]>
    <?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
    <![endif]-->
<?php
}

$random = rand();
?>

<div id="detail_graph_<?= $random.$counter['Counter']['id']?>" class="counter-graph counter-detail"></div>
<div id="master_graph_<?= $random.$counter['Counter']['id']?>" class="counter-graph counter-master"></div>


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
            create_zomming_plot(
                "#master_graph_<?= $random.$counter['Counter']['id']?>", 
                "#detail_graph_<?= $random.$counter['Counter']['id']?>", 
                dataDetail, 
                ops);
        });            
    })();
    
</script>