<?php
echo $this->Html->css('/skpi/css/graphs');

?>

  <h1 class="text-center">Detalles del KPI <i>"<?= $kpi['Kpi']['name'] ?>"</i></h1>
<div>
      <div class="span6">

        <h3 class="text-center">Viendo datos del Sitio <?= $site['Site']['name'] ?></h3>
        <?php


        if ( $this->layout == 'default') {
            echo $this->Element('kpi_site_date_search');
        }


        $kpisDates = array_values($days);

        $headers = array();
        // formatear la fecha
        foreach ($kpisDates as $date) {
          
          $currDate = date('d-m-y', strtotime($date));
          if ( $currDate == date('d-m-y')) {
            $currDate = 'Hoy(parcial)';
          }
            $headers[] = $currDate;
        }
        // colocar al inicio el texto        
        array_unshift($headers, '&nbsp;');
        $headers[] = 'AVG';


        $cels = array();
        foreach ($kpiValues as $kpv ) {
            $row = array(array($kpv['Title'][0], array('class' => $kpv['Title'][1] )));
            $i = $avg = 0;
            foreach ( $kpv['Day'] as $dv) {

              $val = $dv[0]['valor'];
              if ($val) {
                  $avg += $val;
                  $i++;
              }
              $class = $this->Kpi->thresholdEval($val, $dv['Kpi']['sql_threshold_warning'], $dv['Kpi']['sql_threshold_danger']);
              $ops['class'] = $class;
              $row[] = $this->Kpi->format_bg_class($val, $dv['Kpi']['string_format'], $ops);
            }

            if ($i) {
                $val = $avg / $i;
                $class = $this->Kpi->thresholdEval($val, $dv['Kpi']['sql_threshold_warning'], $dv['Kpi']['sql_threshold_danger']);
                $ops['class'] = $class;
                $val = $this->Kpi->format_bg_class($val, $dv['Kpi']['string_format'], $ops);
            } else {
                $val = '';
            }
            $row[] = $val;
            $cels[] = $row;

        }

        ?>

        <h4>Tabla de KPI´s</h4>
        <table class="table table-bordered table-condensed table-kpis table-hover">
        <?php

        echo $this->Kpi->tHead($headers);

        echo $this->Html->tableCells($cels);
        ?>

        </table>

        
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