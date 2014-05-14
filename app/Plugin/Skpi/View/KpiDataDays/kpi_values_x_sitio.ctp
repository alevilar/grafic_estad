<?php echo $this->Element('kpi_site_date_search'); ?>

<h2 style="float: left; margin-right: 40px;"><?php echo $title_for_layout?></h2>

<div class="clearfix"></div>


<?php 

        $supernew = array();
        $dates = array();
        foreach ($kpis as $site) {
            $siteData = array();
            $siteId = $site['Site']['id'];
            $siteData[] = "<input type='radio' name='selected_site' value='$siteId' id='selected-radio-$siteId'>"
                        .$this->Html->link($site['Site']['name'],'by_site/'.$site['Site']['id']);
            foreach ( $site['Day'] as $dataDay) {
                    // recolectar los dias para armar en el header
                    
                    $value = '';
                    if ( !empty($dataDay[0]['valor'])  ) {
                        $value = $dataDay[0]['valor'];
                    }
                    
                    if ( !empty($value) && !empty( $kpi['Kpi']['string_format']) ) {
                        $value = sprintf($kpi['Kpi']['string_format'], $value );
                    }
                    $siteData[] = $value;
            }
            $supernew[] = $siteData;
        }        
?>
    

    <div class="span5">
        <table class="table table-bordered table-condensed table-kpis table-hover">

        <thead>
        <?php
                $header[] = 'Sitio';
                foreach ($days as $d) {
                    $header[] = strftime('%a %d', strtotime($d));
                }                
                echo $this->Html->tableHeaders( $header );      
        ?>
        </thead>


        <?php
            echo $this->Kpi->tCells( $supernew );
        ?>
        </table>
    </div>


    <div class="span6" id="grafico">
        <div id="graph"></div>
    </div>


<script>
    var WWWROOT = "<?php echo $this->Html->url('/', true);?>";
    var ROTMS = <?php Configure::read('Sky.msRotacionSitios');?>;
</script>
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