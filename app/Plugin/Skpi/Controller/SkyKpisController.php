<?php
App::uses('AppController', 'Controller');
/**
 * SkyKpis Controller
 *
 * @property SkyKpi $SkyKpi
 * @property PaginatorComponent $Paginator
 */
class SkyKpisController extends AppController {

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
	public function index() {
		$this->SkyKpi->recursive = 0;
		$this->set('skyKpis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SkyKpi->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$options = array('conditions' => array('SkyKpi.' . $this->SkyKpi->primaryKey => $id));
		$this->set('skyKpi', $this->SkyKpi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SkyKpi->create();
			if ($this->SkyKpi->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
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
	public function edit($id = null) {
		if (!$this->SkyKpi->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SkyKpi->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('SkyKpi.' . $this->SkyKpi->primaryKey => $id));
			$this->request->data = $this->SkyKpi->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SkyKpi->id = $id;
		if (!$this->SkyKpi->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SkyKpi->delete()) {
			$this->Session->setFlash(__d('croogo', 'Sky kpi deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Sky kpi was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->SkyKpi->recursive = 0;
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
		if (!$this->SkyKpi->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$options = array('conditions' => array('SkyKpi.' . $this->SkyKpi->primaryKey => $id));
		$this->set('skyKpi', $this->SkyKpi->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SkyKpi->create();
			if ($this->SkyKpi->save($this->request->data)) {
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
		if (!$this->SkyKpi->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SkyKpi->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The sky kpi has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The sky kpi could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('SkyKpi.' . $this->SkyKpi->primaryKey => $id));
			$this->request->data = $this->SkyKpi->find('first', $options);
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
		$this->SkyKpi->id = $id;
		if (!$this->SkyKpi->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid sky kpi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SkyKpi->delete()) {
			$this->Session->setFlash(__d('croogo', 'Sky kpi deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Sky kpi was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}}
