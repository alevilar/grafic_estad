<?php
App::uses('WorkflowAppModel','Workflow.Model');
/**
 * State Model
 *
 * @property StateTable $StateFrom
 * @property StateTable $StateTo
 */
class State extends WorkflowAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
	
/**
 * Default Find order
 *
 * @var array
 */
	public $order = array('State.order');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'order' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'StateFrom' => array(
			'className' => 'StateTable',
			'foreignKey' => 'state_from',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'StateTo' => array(
			'className' => 'StateTable',
			'foreignKey' => 'state_to',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
