<?php
App::uses('SkyAppController', 'Sky.Controller');


class FecsController extends SkyAppController {
		
	
	public function admin_index () {
		$this->set('title_for_layout', __d('sky', 'Fec'));		
		$this->Fec->recursive = 0;
		$this->set('fecs', $this->paginate());
		$this->set('displayFields', $this->Fec->displayFields());
	}
	
	
	/**
	 * Admin add
	 *
	 * @return void
	 * @access public
	 */
	public function admin_add() {
		if (!empty($this->request->data)) {
			$this->Fec->create();
			$this->request->data['Fec']['activation_key'] = md5(uniqid());
			if ($this->Fec->save($this->request->data)) {
				$this->Session->setFlash(__d('sky', 'The Fec has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('sky', 'The Fec could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * Admin edit
 *
 * @param integer $id
 * @return void
 * @access public
 */
	public function admin_edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->Fec->save($this->request->data)) {
				$this->Session->setFlash(__d('sky', 'The Fec has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('sky', 'The Fec could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
                        $this->Fec->recursive = -1;
			$this->request->data = $this->Fec->read(null, $id);
		}
		$this->set('editFields', $this->Fec->editFields());
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
			$this->Session->setFlash(__d('sky', 'Invalid id for Fec'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Fec->delete($id)) {
			$this->Session->setFlash(__d('sky', 'Fec deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__d('sky', 'Fec cannot be deleted'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	
}
	