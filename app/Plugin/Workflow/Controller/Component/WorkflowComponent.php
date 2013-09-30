<?php

/**
 * Workflow Component
 *
 * @package Croogo.Workflow.Controller.Component
 */
class WorkflowComponent extends Component {


	/**
	 * initialize
	 *
	 * @param Controller $controller instance of controller
	 */
		public function initialize(Controller $controller) {
			$this->controller = $controller;
			if (isset($controller->State)) {
				$this->State = $controller->State;
			} else {
				$this->State = ClassRegistry::init('Workflow.State');
			}
		}
			
			
/**
 * beforeRender
 *
 * @param object $controller instance of controller
 * @return void
 */
	public function beforeRender(Controller $controller) {
		$defaultStateId = Configure::read('Workflow.defaultStateId');
		$typeAlias = $controller->Node->type;
		if ($controller->action == 'edit' || $controller->action == 'admin_edit') {
			$roleId = $controller->Session->read('Auth.User.role_id');
			$type = $controller->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
			
			$getStateId = $controller->Node->field('state_id');
			$stateFromId = empty($getStateId) ? $defaultStateId : $getStateId;
			$conditions = array(
				'StateTable.type_id' => $type['Type']['id'],
				'StateTable.role_id' => $roleId,
				'StateTable.state_from' => $stateFromId,
				);
			$StateTable = ClassRegistry::init('Workflow.StateTable');
			$possibleStates = $StateTable->find('list', array(
				'conditions' => $conditions,
				'group' => 'StateTable.state_to',
				'fields' => 'state_to',
			));
			$controller->set('states', $this->State->find( 'list', array( 'conditions' => array('State.id' => $possibleStates) )));	
		} elseif ($controller->action == 'add' || $controller->action == 'admin_add') {
			$controller->set('states', $this->State->find( 'list', array( 'conditions' => array('State.id' => $defaultStateId) )));
		}
		
	}


}
