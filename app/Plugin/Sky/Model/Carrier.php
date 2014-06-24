<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * SkyCarrier Model
 *
 * @property Sector $Sector
 */
class Carrier extends SkyAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	public $actsAs = array(
    	'Containable',
    );

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
		'sector_id' => array(
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
		'Sky.Sector',
	);


	public function getSite ( $carrier_id = null) {
		if (empty($carrier_id)) {
			$carrier_id = $this->id;
		}
		$this->contain('Sector.Site');
		$carrier = $this->read(null, $carrier_id);
		if (!empty($carrier)) {
			return $carrier['Sector']['Site'];
		}
		return false;
	}


	public function listObjectnos () {
		$cs = $this->find('all', array(
			'contain' => array('Sector'=>array('Site')),
			// 'group'=>'objectno', 
			'order' => 'objectno'
			)
		);

		$clist = array();
		foreach ( $cs as $c ) {			
			$name = $c['Carrier']['objectno'];
			$name .= " (";
			if (!empty($c['Sector']) && !empty($c['Sector']['Site'])) {
				$name .= $c['Sector']['Site']['name'];	
			}

			if ( !empty($c['Sector']) ) {
				$name .= " s:".$c['Sector']['name'];
			}

			$name .= " c:".$c['Carrier']['name'];
			
			$name .= ")";
			$clist[ $c['Carrier']['objectno'] ] = $name;
		}		
		return $clist;
	}
}
