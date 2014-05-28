<?php
$htmllink = $this->Html->link(
         'Ver Kpi´s de '.$site['Site']['name'], 
         array(
             'controller' => 'data_days',
             'action' => 'view', 
             'site',
             $site['Site']['id']), 
         array(
             'class' => 'btn btn-large btn-success'
             ));

echo json_encode( array(
	'kpis' => array( $metricsDl, $metricsUl ), 
	'sitio' => $site, 
	'sitio_link' => $htmllink,
	'title_for_layout' => $title_for_layout
	), JSON_NUMERIC_CHECK);


