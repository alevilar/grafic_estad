<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * SkySector Model
 *
 * @property Site $Site
 */
class Sector extends SkyAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

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
		)
	);
        
        
        public $hasMany = array(
		'Sky.Carrier',
	);



	public function getSite ( $id = null) {
		if (empty($id)) {
			$id = $this->id;
		}
		$this->contain('Site');
		$sector = $this->read(null, $id);
		if (!empty($sector)) {
			return $sector['Site'];
		}
		return false;
	}        
        
        
        
        public function listCarriers( $id = null, $fieldName = 'id' ) {
            
            if ( !empty($id) ) {
                $this->id = $id;
            }
            
            if ( empty($this->id )) {
                throw new Exception('Se debe pasar un id de Sector');
            }
            $sector = $this->find('first', array(
                'conditions' => array(
                    'Sector.id'=> $id
                    ),
                'contain' => array(
                    'Carrier',
                ),                
            ));
            
            $carriers = array();
            
            foreach ($sector['Carrier'] as $carrier) {                    
                $carriers[] = $carrier[$fieldName];
            }
            
            return $carriers;
        }
        
}
