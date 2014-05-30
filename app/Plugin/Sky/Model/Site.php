<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * Site Model
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

    public $cacheQueries = true;

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


    public function beforeFind( $query ) {
        parent::beforeFind($query);
        if ( empty($query['conditions']) && empty($query['conditions']['Site.deleted']) ) {
            $query['conditions']['Site.deleted'] = 0;    
        }
        return $query;
    }


        
        public function listCarriers( $site_id = null, $fieldname = 'id' ) {
            
            if ( !empty($site_id) ) {
                $this->id = $site_id;
            }
            
            if ( empty($this->id )) {
                throw new Exception('Se debe pasar un id de Sitio');
            }
            $site = $this->find('first', array(
                'conditions' => array(
                    'Site.id'=> $this->id
                    ),
                'contain' => 'Sector.Carrier',                
                ));
            
            $carriers = array();
            foreach ( $site['Sector'] as $sector ){
                foreach ($sector['Carrier'] as $carrier) {                    
                    $carriers[] = $carrier[$fieldname];
                }
            }
            return $carriers;
        }

        public function readCarrier( $site_id = null ){
            if ( empty($site_id) ) {
                $site_id = $this->id;
            }
            $this->contain(array('Sector.Carrier'));
            return $this->read(null, $site_id);
        }
}
