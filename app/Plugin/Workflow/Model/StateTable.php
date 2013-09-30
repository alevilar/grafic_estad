<?php
App::uses('WorkflowAppModel', 'Workflow.Model');
/**
 * StateTable Model
 *
 * @property Role $Role
 * @property Type $Type
 * @property State $StateFrom
 * @property State $StateTo
 */
class StateTable extends WorkflowAppModel {


	 public $displayField = 'name';
	 
	 public $virtualFields = array(
	    'name' => 'CONCAT(StateTable.state_from, ",", StateTable.state_to)'
	);
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Type' => array(
			'className' => 'Type',
			'foreignKey' => 'type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StateFrom' => array(
			'className' => 'State',
			'foreignKey' => 'state_from',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StateTo' => array(
			'className' => 'State',
			'foreignKey' => 'state_to',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function tableFrom($roleId, $typeId){
		return $this->find('all', array(
				'conditions' => array(
					'StateTable.role_id' => $roleId,
					'StateTable.type_id' => $typeId,
				)
			));
	}
}
