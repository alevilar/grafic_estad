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

        if ( !array_key_exists('conditions', $query) ) {
            $query['conditions'] = array();            
        }

        if ( is_array($query['conditions']) && empty($query['conditions']['Site.deleted']) ){
            $query['conditions']['Site.deleted'] = 0;
        }
        return $query;
    }


        /**
         * Lista los carriers como un find 'list'
         * @param int or array $site_id puede ser el ID del sitio o un array de ID´s de sitio
         * @param $fieldname el campo que quiero que me devuelva como valor del array de retorno
         */
        public function listCarriers( $site_id = null, $fieldname = 'id' ) {
            $conds = array();

            if ( !empty($site_id) ) {
                $conds['Site.id'] = $site_id;
            }
            if ( !empty($this->id) ) {
                $conds['Site.id'] = $this->id;
            }

            if ( is_array( $site_id ) ) {
                $conds['Site.id'] = $site_id ;
            }
            
            $sites = $this->find('all', array(
                'conditions' => $conds,
                'contain' => 'Sector.Carrier',                
                ));
            
            $carriers = array();
            foreach ($sites as $site ) {
                foreach ( $site['Sector'] as $sector ){
                    foreach ($sector['Carrier'] as $carrier) {                    
                        $carriers[] = $carrier[$fieldname];
                    }
                }
            }
            
            return $carriers;
        }


        /**
         * Es la funcion read pero con el Contain de Sectors y Carriers
         * para el sitio
         */
        public function readCarrier( $site_id = null ){
            if ( !is_null( $site_id ) ) {
                $this->id = $site_id;
            }
            $this->contain(array('Sector.Carrier'));
            return $this->read();
        }
}
