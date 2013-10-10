<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * MsLogTable Model
 *
 * @property Site $Site
 * @property Sector $Sector
 * @property Carrier $Carrier
 */
class MsLogTable extends SkyAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'comand_number';
        
        
        public $actsAs = array(
		'Search.Searchable',
	);        
        
/**
 * Filter search fields
 *
 * @var array
 * @access public
 */
	public $filterArgs = array(
		'site_id' => array('type' => 'value'),
		'sector_id' => array('type' => 'value'),
		'carrier_id' => array('type' => 'value'),
                'datetime' => array('type' => 'value'),
                'datetime_from' => array('type' => 'value', 'field' => 'MsLogTable.datetime'),
                'retcode_id' => array('type' => 'value'),
                'om_id' => array('type' => 'value'),
                'comand_number' => array('type' => 'value'),
	);
        
        public $order = array(
            'MsLogTable.datetime DESC', 
            'MsLogTable.site_id',  
            'MsLogTable.sector_id');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'site_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sector_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'carrier_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'datetime' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'om_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'comand_number' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'retcode_id' => array(
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Site' => array(
			'className' => 'Sky.Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sector' => array(
			'className' => 'Sky.Sector',
			'foreignKey' => 'sector_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Carrier' => array(
			'className' => 'Sky.Carrier',
			'foreignKey' => 'carrier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Sky.Retcode',
	);
        
        
        public $hasMany = array(
            'Sky.LogMstation'
            );
            
}
