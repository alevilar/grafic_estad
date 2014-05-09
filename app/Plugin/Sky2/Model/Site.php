<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * SkySite Model
 *
 */
class Site extends SkyAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        
        
        public $order = array('Site.name');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
        
        
        /**
 * belongsTo associations
 *
 * @var array
 */
	public $hasMany = array(
		'Sky.Sector'
	);
}
