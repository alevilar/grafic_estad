<?php

App::uses('SkpiAppController', 'Skpi.Controller');

class DataCountersController extends SkpiAppController
{

	 public $components = array(
		'Croogo.Croogo',
		'Security',
		'Acl',
		'Auth',
		'Session',
		'RequestHandler',
        'DebugKit.Toolbar',
        'Paginator',
        'Search.Prg',
	);

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

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {

		$this->Prg->commonProcess();		
		$conds = $this->DataCounter->parseCriteria($this->request->query);
		$datetime_desde = null;

		if (!empty($conds['DataCounter.objectno'])) {
			$this->request->data['DataCounter']['objectno'] = $conds['DataCounter.objectno'];
		}

		if (!empty($conds['DataCounter.date_time >='])) {
			$this->request->data['DataCounter']['date_time_desde'] = $conds['DataCounter.date_time >='];
		}
		$datetime_hasta = null;
		if (!empty($conds['DataCounter.date_time <='])) {
			$this->request->data['DataCounter']['date_time_hasta'] = $conds['DataCounter.date_time <='];
			
		}

        $this->Paginator->settings['conditions'] = $conds;
        $this->Paginator->settings['contain'] = array('Carrier' => array( 'Sector.Site'));

		$this->DataCounter->recursive = 0;

		$this->DataCounter->Carrier->primaryKey = 'objectno';

		$cols = $this->DataCounter->getColumnTypes();
		$cols['times_when_dl_rssi_ranges_from__89_dbm_to__80_dbm'] = '';
		$cols['times_when_dl_rssi_is_not_higher_than__90_dbm'] = '';
		$cols['times_when_ul_rssi_ranges_from__89_dbm_to__80dbm'] = '';
		$cols['times_when_ul_rssi_is_not_higher_than__90dbm'] = '';		
		$fields = array_keys($cols);

		// estos, no se porque, pero no son listados por getColumnTypes
		
		if ( array_key_exists('ext', $this->request->params) && $this->request->params['ext'] == 'xls') {			
			$this->Paginator->settings['limit'] = Configure::read('Sky.max_reg_export');
			if ( $this->Paginator->settings['limit'] == 0 ) {
				$this->Paginator->settings['limit'] = 9999999999;
				$this->Paginator->settings['maxLimit'] = 9999999999;

			}
		}

		$this->set('dataCounters', $this->Paginator->paginate() );	

		$this->set('datetime_desde', $datetime_desde);
		$this->set('datetime_hasta', $datetime_hasta);
		$this->set('fields', $fields);
		
		
		$this->set('objectnos', $this->DataCounter->Carrier->listObjectnos());
	}


}