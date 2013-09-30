<?php

App::uses('WorkflowApp','Workflow.Controller');


class StatesController extends WorkflowAppController{
	
	function admin_index(){
		$this->set('title_for_layout', __d('croogo', 'States'));

		$this->State->recursive = 0;
		$this->set('vocabularies', $this->paginate());
		
		$this->set('states', $this->paginate());
	}
	
	
	function admin_add(){
		$this->set('title_for_layout', __d('croogo', 'Add State'));

		if (!empty($this->request->data)) {
			$this->State->create();
			if ($this->State->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The State has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The State could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}
	
	
	function admin_edit($id){
		$this->set('title_for_layout', __d('croogo', 'Edit State'));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__d('croogo', 'Invalid State'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->State->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The State has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The State could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->State->read(null, $id);
		}
	}
	
	
	/**
	 * Admin delete
	 *
	 * @param integer $id
	 * @return void
	 * @access public
	 */
	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('croogo', 'Invalid id for State'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash(__d('croogo', 'State deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function admin_how_does_it_works(){
		
	}
}
