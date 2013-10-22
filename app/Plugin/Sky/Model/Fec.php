<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * SkyFec Model
 *
 */
class Fec extends SkyAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
        
        
        
/**
 * Display fields for this model
 *
 * @var array
 */
	protected $_displayFields = array(		
		'id',
                'modulation',
                'line_color',
	);

/**
 * Edit fields for this model
 *
 * @var array
 */
	protected $_editFields = array(
		'id',
                'modulation',
                'line_color',
	);
        
        
        public $virtualFields = array(
            'full_name' => 'CONCAT(Fec.id, " - ", Fec.modulation)',
        );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modulation' => array(
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
        
        public function __construct($id = false, $table = null, $ds = null) {
            parent::__construct($id, $table, $ds);
            $this->virtualFields['full_name'] = sprintf('CONCAT(%s.id, " - ", %s.modulation)', $this->alias, $this->alias);
        }
}
