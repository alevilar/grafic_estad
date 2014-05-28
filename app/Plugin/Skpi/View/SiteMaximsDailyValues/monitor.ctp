<?php echo $this->Element('kpi_site_date_search', array('modelName' => 'SiteMaximsDailyValue')); ?>


<div class="clearfix"></div>


<div>

<?php 
        $cells = array();
        $dataDays = array();
        foreach ( $sitesMaxims as $siteId => $k ) {  
            $url = array(
                'controller' => 'SiteMaximsDailyValues',
                'action' => 'graph_jplot',
                $siteId,
                );
            if ( !empty($busqueda) ) {
                $url[] = $this->request->data['SiteMaximsDailyValue']['date_from'];
                if (!empty($this->request->data['SiteMaximsDailyValue']['date_to'])) 
                    $url[] = $this->request->data['SiteMaximsDailyValue']['date_to'];
            }
            $url = $this->Html->url($url,true);

            $imp = "<input type='radio' name='selected_site' value='$siteId' id='selected-radio-$siteId' data-url='$url'>";
            $row = array( $imp . $sites[$siteId] );

            // recorrer los valores y seguir armando el array para la fila
            // por cada dia
            foreach ($k as $day ) {
                $dd = date('Y-m-d', strtotime($day['SiteMaximsDailyValue']['ml_datetime']));
                $dataDays[$dd] = $dd;
                $row[] = sprintf("<b>%g</b> Mbps",$day['SiteMaximsDailyValue']['dl_value']);
                $row[] = sprintf("<b>%.0f</b> Mbps",$day['SiteMaximsDailyValue']['ul_value']);
            }
            $cells[] = $row;
        }
?>
    

    <div class="span6">
        <table class="table table-bordered table-condensed table-kpis table-hover">

        <thead>
        <?php
                $days = array_values($dataDays);

                $header2= array();
                $days = array();
                foreach( $dataDays as $date) {
                    $header2[] = 'DL';
                    $header2[] = 'UL';
                    $date = date('Y-m-d', strtotime($date));
                    if ( $date  == date('Y-m-d', strtotime('now') ))  {
                        $days[] = 'Hoy(parcial)';
                    } else {
                        $days[] = $date;
                    }
                }        
                ?>
                <tr>
                    <th>&nbsp;</th>
                <?php
                foreach ( $days as $date) {
                    echo "<th colspan='2'>$date</th>";
                }
                ?>
                </tr>

                <?php

                array_unshift( $header2, 'Sitio');
                echo $this->Html->tableHeaders( $header2 );      

                
        ?>
        </thead>


        <?php
            echo $this->Kpi->tCells( $cells );
        ?>
        </table>
    </div>


    <div class="span6" id="grafico">
        <div  style="position: fixed; bottom: 50px; width: 50%">
            <div id="graph"></div>
            <br>
            <div class="text-center" id="site-link"></div>
        </div>
    </div>
</div>

<?= $this->element('scroll_interval_to_js'); ?>

<script>
     var WWWROOT = "<?php echo $this->Html->url('/', true);?>";
</script>


<?php

echo $this->Html->script('/skpi/js/graphs/kpi_graph');
echo $this->Html->script('/skpi/js/max_uldl');
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
    //'/jqplot/plugins/jqplot.highlighter.min',
    '/jqplot/plugins/jqplot.cursor.min',
));
?>