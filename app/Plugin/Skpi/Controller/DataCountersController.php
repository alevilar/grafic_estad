<?php

App::uses('SkpiAppController', 'Skpi.Controller');

class DataCountersController extends SkpiAppController
{
	public function graph_zooming ( $site_id, $counter_id = SK_COUNTER_DL_AVG, $date_from = null, $date_to = null) {
				
		// set default value for date from
		if ( empty($date_from) ) {
			$date_from = date('Y-m-d', strtotime('-1 month') );
		}


		// set default value for date  to
		if ( empty($date_to) ) {
			$date_to = date('Y-m-d');
		}

		// Get Counter
		$Counter = ClassRegistry::init('Skpi.Counter');
		$Counter->recursive = -1;
		$counter = $Counter->read(null, $counter_id);

		$metrics = $this->DataCounter->getDataCounter('site', $site_id, $counter_id, $date_from, $date_to);
		$this->set(compact('metrics', 'counter'));		
	}


}