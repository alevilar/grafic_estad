<?php
App::uses('SkpiAppController', 'Skpi.Controller');

/**
 * ProbeValues Controller
 *
 * @property ProbeValue $ProbeValue
 * @property PaginatorComponent $Paginator
 */
class ProbeValuesController extends SkpiAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Croogo.Croogo',
		'Security',
		'Acl',
		'Auth',
		'Session',
		'RequestHandler',
        'DebugKit.Toolbar',
        'RequestHandler',
        'Paginator',
        'Search.Prg' => array(
            'presetForm' => array(
                'paramType' => 'querystring',
            ),
            'commonProcess' => array(
                'paramType' => 'querystring',
                'filterEmpty' => true,
            ),
        ),
	);

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Prg->commonProcess();
        $conds = $this->ProbeValue->parseCriteria($this->request->query);
        $this->Paginator->settings['conditions'] = $conds;
		$this->ProbeValue->recursive = 0;

		if ( array_key_exists('ext', $this->request->params) && $this->request->params['ext'] == 'xls') {			
			$this->Paginator->settings['limit'] = Configure::read('Sky.max_reg_export');
			if ( $this->Paginator->settings['limit'] == 0 ) {
				$this->Paginator->settings['limit'] = 9999999999;
				$this->Paginator->settings['maxLimit'] = 9999999999;

			}
		}

		$this->set('probeValues', $this->Paginator->paginate());
		$this->set('probes', $this->ProbeValue->Probe->find('list'));
	}




	public function by_day() {
		Configure::write('debug', 1);

		$this->Prg->commonProcess();
        $conds = $this->ProbeValue->parseCriteria($this->request->query);

		$probes = $this->ProbeValue->Probe->find('all', array('recursive'=>-1));
		$pvals = array();
		if ( empty($conds['DATE(ProbeValue.date_time) >=']) ) {
			$conds['ProbeValue.date_time >='] = date('Y-m-d H', strtotime('-28 hour'));
		}

		if ( !empty($conds['DATE(ProbeValue.date_time) >=']) ) {
			$this->request->data['ProbeValue']['date_from'] = $conds['DATE(ProbeValue.date_time) >='];
		}

		if ( !empty($conds['DATE(ProbeValue.date_time) <=']) ) {
			$this->request->data['ProbeValue']['date_to'] = $conds['DATE(ProbeValue.date_time) <='];
		}


		foreach ($probes as $p) {
			$pId = $p['Probe']['id'];
			$conds['ProbeValue.probe_id'] = $pId;

			$ops = array(
				'conditions' => $conds,
				'group' => array(
					'DATE(ProbeValue.date_time)',
					'HOUR(ProbeValue.date_time)',
					),
				'fields' => array(
					'DATE(ProbeValue.date_time) as date',
					'HOUR(ProbeValue.date_time) as hour',
					'AVG(ProbeValue.dl) as dl',
					'AVG(ProbeValue.ul) as ul',
					),
				'order' => array(
					'DATE(ProbeValue.date_time)',
					'HOUR(ProbeValue.date_time)',
					),
				);

			$p['ProbeValue'] = $this->ProbeValue->find('all', $ops);

			$pvals[$pId] = $p;
		}

		$this->set('probeValues', $pvals);

	}



/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->ProbeValue->exists($id)) {
			throw new NotFoundException(__('Invalid probe value'));
		}
		$options = array('conditions' => array('ProbeValue.' . $this->ProbeValue->primaryKey => $id));
		$this->set('probeValue', $this->ProbeValue->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ProbeValue->create();
			if ($this->ProbeValue->save($this->request->data)) {
				$this->Session->setFlash(__('The probe value has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The probe value could not be saved. Please, try again.'));
			}
		}
		$probes = $this->ProbeValue->Probe->find('list');
		$this->set(compact('probes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->ProbeValue->exists($id)) {
			throw new NotFoundException(__('Invalid probe value'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ProbeValue->save($this->request->data)) {
				$this->Session->setFlash(__('The probe value has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The probe value could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ProbeValue.' . $this->ProbeValue->primaryKey => $id));
			$this->request->data = $this->ProbeValue->find('first', $options);
		}
		$probes = $this->ProbeValue->Probe->find('list');
		$this->set(compact('probes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->ProbeValue->id = $id;
		if (!$this->ProbeValue->exists()) {
			throw new NotFoundException(__('Invalid probe value'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ProbeValue->delete()) {
			$this->Session->setFlash(__('The probe value has been deleted.'));
		} else {
			$this->Session->setFlash(__('The probe value could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
