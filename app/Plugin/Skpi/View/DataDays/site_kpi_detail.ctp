<?php
echo $this->Html->css('/skpi/css/graphs');

?>


<style type="text/css">
        .btn-descargar-xls{
            float: right;
        }
</style>


  <h1 class="text-center">Detalles del KPI <i>"<?= $kpi['Kpi']['name'] ?>"</i></h1>
<div>
      <div class="span6">

        <h3 class="text-center">Viendo datos del Sitio <?= $site['Site']['name'] ?></h3>
        <?php


        if ( $this->layout == 'default') {
            echo $this->Element('kpi_site_date_search');
        }


        ?>

        <?php echo $this->element('btn_descargar_excel'); ?>
        <h4>Tabla de KPI´s</h4>
        
        <?php echo $this->element('kpi_view_full_site_sector_carrier');?>

        
    </div>




    <div class="span6">
      <div class="well" style="margin-left: 10%">
          <h4 class="text-center">Detalle del úlimo mes de los Contadores relacionados</h4>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Puede hacer zoom arrastrando y soltando un intervalo dentro del gráfico</div>


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
     </div>


    
</div>