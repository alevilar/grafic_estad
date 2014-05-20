
<h2 style="float: left; margin-right: 40px;"><?php echo $title_for_layout?></h2>

<div class="clearfix"></div>

<div>
    <div class="span6">
     <?php 
     foreach ($counters as $c) {
        echo $this->element(
            'counter_zooming_view', array(
                'counter'=>$c['Counter'], 
                'metrics' => $c['DataCounter']
                )
            );
     }
     ?>
     </div>

      <div class="span6">

        <?php echo $this->element('Skpi.sitio_sectores_y_carriers') ?>
        
        <?php
        // KPI´s TABLE
        echo $this->element('kpis_table', array(
                'days' => $days,
                'kpis' => $kpis,
                'site_id' => $site['Site']['id']
            ));


        if ( $this->layout == 'default') {
            echo $this->Element('kpi_site_date_search');
        }

        ?>

        
    </div>

    
</div>