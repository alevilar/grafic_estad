
<div id="graph"></div>

<?php

echo $this->Html->script('/skpi/js/kpi_graph');
echo $this->Html->script('/skpi/js/max_uldl');



echo $this->Html->css('/jqplot/jquery.jqplot.min');
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->


<?php
echo $this->Html->script(array(
    '/jqplot/jquery.jqplot',
    '/jqplot/plugins/jqplot.dateAxisRenderer.min',
    '/jqplot/plugins/jqplot.pointLabels.min',
    //'/jqplot/plugins/jqplot.highlighter.min',
    '/jqplot/plugins/jqplot.cursor.min',
));
?>


<script>
     var kpis = <?php echo json_encode($kpis, JSON_NUMERIC_CHECK)?>;
     
     createGraph('graph', kpis, "<?php echo $title_for_layout?>");
</script>
