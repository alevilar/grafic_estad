<?php

App::uses('SkpiAppController', 'Skpi.Controller');

class DataCountersController extends SkpiAppController
{
	public function graph_raw_counter ( $site_id, $counter_id = SK_COUNTER_DL_AVG, $date_from = null, $date_to = null) {
				
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
		$Counter->id = $counter_id;
		$counter = $Counter->read();
		if (empty($counter)) {
			throw new NotFoundException("El Counter ID $counter_id  no fue encontrado en la tabla");			
		}

		$counterColName = $counter['Counter']['col_name'];

		$metrics = $this->DataMetric->getDataForSiteCounter($site_id, $counterColName, $date_from, $date_to);

		$this->set(compact('metrics', 'counter'));		
	}
}