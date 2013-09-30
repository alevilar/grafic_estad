<?php

App::uses('WorkflowAppController', 'Workflow.Controller');


class StateTablesController extends WorkflowAppController{
	
	public $uses = array('Workflow.StateTable', 'Workflow.State');
	
	public function admin_index(){
		
		$roles = $this->StateTable->Role->find('list');
		$types = $this->StateTable->Type->find('list');
		
		$this->set(compact('roles','types'));
	}
	
	
	
	function admin_table($role_id = null, $type_id = null){
		

		if (!empty($this->request->data)) {
			$role_id = $this->request->data['StateTable']['role_id'];
			$type_id = $this->request->data['StateTable']['type_id'];
		}
		
		
		if ( !empty($role_id) && !empty($type_id) ) {
			
			$this->StateTable->Role->id = $role_id;
			$role = $this->StateTable->Role->field('title');
			
			$this->StateTable->Type->id = $type_id;
			$contentType = $this->StateTable->Type->field('title');
			
			$this->set('title_for_layout', __d('croogo', "Changing State Table"));
			$this->set('roleName', $role);
			$this->set('contentTypeName', $contentType);
			
			// set hidden data into form
			$this->request->data['StateTable']['role_id'] = $role_id;
			$this->request->data['StateTable']['type_id'] = $type_id;
		
			$stateTables = $this->StateTable->tableFrom($role_id, $type_id);
			
			foreach ( $stateTables as $st ) {
				$this->request->data['checkedStates'][$st['StateTable']['state_from']][$st['StateTable']['state_to']] = true;
			}
			
			$states = $this->State->find('list');
			$this->set(compact('stateTables','states'));
			
		} else {
			$this->Session->setFlash(__d('croogo', 'You have to select Role and Type'), 'default', array('class' => 'error'));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	
	function admin_table_process(){
		$this->StateTable->recursive = -1;
		
		if (!empty($this->request->data)) {
			$role_id = $this->request->data['StateTable']['role_id'];
			$type_id = $this->request->data['StateTable']['type_id'];
			
			$stateTables = $this->StateTable->tableFrom($role_id, $type_id);
			
			// save checked states 
			foreach ($this->request->data['checkedStates'] as $fromId=>$from) {
				foreach ($from as $toId=>$value) {
					$conds = array(
						'role_id' => $role_id,
						'type_id' => $type_id,
						'state_from' => $fromId,
						'state_to' => $toId,
					);
					
					if ( empty($value) ) {
						// delete
						$this->StateTable->deleteAll($conds);
						
					} else {
						// save
						$findOne = $this->StateTable->find('list',array('conditions'=>$conds));
						if (!empty($findOne)) {
							// upload existing
							if (count($findOne)>1){
								throw new Exception("Error, cannot be two records of that",1);
							}
							$thisId = array_keys($findOne);
							$thisId = $thisId[0];
							$conds['id'] = $thisId;
						} else {
							// create new record
							$this->StateTable->create();
						}
						$this->StateTable->save( array('StateTable'=>$conds) );
					}
				}
			}
		}
		$this->Session->setFlash(__d('croogo', 'States Table Saved'), 'default', array('class' => 'success'));
		$this->redirect(array('action' => 'index'));
	}
}
