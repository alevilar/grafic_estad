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
}
