<?php

echo json_encode( array(
	'kpis' => $kpis, 
	'sitio' => $sitio, 
	'sitio_link' => $this->Html->link('Ver Kpi´s de este sitio', array('action'=>'by_site', $sitio), array('class' => 'btn btn-large btn-success')),
	'title_for_layout' => $title_for_layout
	), JSON_NUMERIC_CHECK);
