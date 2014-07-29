<?php
App::uses('SkpiAppController', 'Skpi.Controller');
/**
 * Probes Controller
 *
 * @property Probe $Probe
 * @property PaginatorComponent $Paginator
 */
class ProbesController extends SkpiAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Probe->recursive = 0;
		$this->set('probes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Probe->exists($id)) {
			throw new NotFoundException(__('Invalid probe'));
		}
		$options = array(
			'conditions' => array(
				'Probe.' . $this->Probe->primaryKey => $id
				),
			'contain' => array(
				'ProbeValue' => array(
						'order' => array('ProbeValue.date_time ASC'),
						'conditions' => array(
							'DATE(ProbeValue.date_time) >=' => date('Y-m-d', strtotime('-3 month')),
							)
					)
				)
			);

		$Counter = ClassRegistry::init('Skpi.Counter');
		$Counter->recursive = -1;
		$this->set('dlCounter', $Counter->read(null, SK_COUNTER_DL_AVG) );
		$this->set('ulCounter', $Counter->read(null, SK_COUNTER_UL_AVG) );

		$this->set('probe', $this->Probe->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Probe->create();
			if ($this->Probe->save($this->request->data)) {
				$this->Session->setFlash(__('The probe has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The probe could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Probe->exists($id)) {
			throw new NotFoundException(__('Invalid probe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Probe->save($this->request->data)) {
				$this->Session->setFlash(__('The probe has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The probe could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Probe.' . $this->Probe->primaryKey => $id));
			$this->request->data = $this->Probe->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Probe->id = $id;
		if (!$this->Probe->exists()) {
			throw new NotFoundException(__('Invalid probe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Probe->delete()) {
			$this->Session->setFlash(__('The probe has been deleted.'));
		} else {
			$this->Session->setFlash(__('The probe could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
