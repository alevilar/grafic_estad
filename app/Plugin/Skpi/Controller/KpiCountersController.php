<?php

App::uses('SkpiAppController', 'Skpi.Controller');
/**
 * KpiCounters Controller
 *
 * @property KpiCounter $KpiCounter
 * @property PaginatorComponent $Paginator
 */
class KpiCountersController extends SkpiAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->KpiCounter->recursive = 0;
		$this->set('skyKpis', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->KpiCounter->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$options = array('conditions' => array('KpiCounter.' . $this->KpiCounter->primaryKey => $id));
		$this->set('skyKpi', $this->KpiCounter->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->KpiCounter->create();
			if ($this->KpiCounter->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->KpiCounter->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->KpiCounter->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('KpiCounter.' . $this->KpiCounter->primaryKey => $id));
			$this->request->data = $this->KpiCounter->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->KpiCounter->id = $id;
		if (!$this->KpiCounter->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->KpiCounter->delete()) {
			$this->Session->setFlash(__d('croogo', 'Sky kpi deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Sky kpi was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}}
