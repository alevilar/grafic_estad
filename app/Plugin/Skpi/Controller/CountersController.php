<?php

App::uses('SkpiAppController', 'Skpi.Controller');
/**
 * KpiCounters Controller
 *
 * @property Counter $Counter
 * @property PaginatorComponent $Paginator
 */
class CountersController extends SkpiAppController {

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
		$this->Counter->recursive = 0;
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
		if (!$this->Counter->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$options = array('conditions' => array('Counter.' . $this->Counter->primaryKey => $id));
		$this->set('skyKpi', $this->Counter->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Counter->create();
			if ($this->Counter->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}

		$this->set('kpis', $this->Counter->Kpi->find('list'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Counter->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Counter->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Counter.' . $this->Counter->primaryKey => $id));
			$this->request->data = $this->Counter->find('first', $options);
		}
		$this->set('kpis', $this->Counter->Kpi->find('list'));
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
		$this->Counter->id = $id;
		if (!$this->Counter->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Counter->delete()) {
			$this->Session->setFlash(__d('croogo', 'Sky kpi deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Sky kpi was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

}
