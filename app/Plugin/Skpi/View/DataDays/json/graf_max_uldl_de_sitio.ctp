<?php

 $htmllink = $this->Html->link(
         'Ver Kpi´s de este sitio', 
         array(
             'action' => 'by_site', 
             $sitio['Site']['id']), 
         array(
             'class' => 'btn btn-large btn-success'
             ));

echo json_encode( array(
	'kpis' => $kpis, 
	'sitio' => $sitio, 
	'sitio_link' => $htmllink,
	'title_for_layout' => $title_for_layout
	), JSON_NUMERIC_CHECK);
