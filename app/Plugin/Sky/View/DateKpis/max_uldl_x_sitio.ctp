<?php echo $this->Element('kpi_site_date_search'); ?>

<h2 style="float: left; margin-right: 40px;"><?php echo $title_for_layout?></h2>

<div class="clearfix"></div>


<?php 

    
    // dar vuelta la fecha
 // dar vuelta la tabla para que quede ordenado por fecha
        $newkpi = array();
        $headers = array();
        foreach ( $kpis as $k ) {     
            $site_id = $k['Carrier']['Sector']['Site']['id'];
            $site_name = $k['Carrier']['Sector']['Site']['name'];    
            $newkpi[ $site_id ][ $k['DateKpi']['date'] ]['site_name'] = $site_name;     
            $headers[$k['DateKpi']['date']] = $k['DateKpi']['date'];
            $newkpi[ $site_id ][ $k['DateKpi']['date'] ]['site_name'] = $site_name;
            $newkpi[ $site_id ][ $k['DateKpi']['date'] ]['max_dl'] = $k['DateKpi']['max_dl'];
            $newkpi[ $site_id ][ $k['DateKpi']['date'] ]['max_ul'] = $k['DateKpi']['max_ul'];                    
        }

        $supernew = array();
        foreach ($newkpi as $siteId=>$siteVal) {           
            $supernew[$siteId][] = 
                "<input type='radio' name='selected_site' value='$siteId' id='selected-radio-$siteId'>"
                .$sites_list[$siteId];
            foreach ( $siteVal as $date=>$d) {                
                $supernew[$siteId][] = $this->Kpi->format_bg_class( 'max_dl', $d['max_dl'] ) ;
                $supernew[$siteId][] = $this->Kpi->format_bg_class( 'max_ul', $d['max_ul'] ) ;
            }
        }
?>
    

    <div class="span5">
        <table class="table table-bordered table-condensed table-kpis table-hover">

        <thead>
        <?php

                $kpisDates = array_values( $headers );

                $header2= array();
                foreach( $kpisDates as $date) {
                    $header2[] = 'DL';
                    $header2[] = 'UL';
                }        
                ?>
                <tr>
                    <th>&nbsp;</th>
                <?php
                foreach ( $kpisDates as $date) {
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
            echo $this->Kpi->tCells( $supernew );
        ?>
        </table>
    </div>


    <div class="span6" id="grafico">
        <div id="graph"></div>
        <div class="text-center" id="site-link"></div>
    </div>


<script>
    var WWWROOT = "<?php echo $this->Html->url('/', true);?>";
</script>
<?php

echo $this->Html->script('/sky/js/max_uldl');


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