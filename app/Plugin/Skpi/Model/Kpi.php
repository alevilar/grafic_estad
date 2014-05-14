<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * KpiCounter Model
 *
 * @property Sector $Sector
 */
class Kpi extends SkpiAppModel {
    
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
		'col_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'string_format' => array(
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
        

    public $hasMany = array('Skpi.KpiDailyValue');
    
    
    /**
     * Filter search fields
     *
     * @var array
     * @access public
     */
    public $filterArgs = array(
        'mstation_id' => array('type' => 'query', 'method' => 'mstationFilter'),
        'status_id' => array('type' => 'value'),
        'mimo_id' => array('type' => 'query', 'method' => 'searchMimoById'),
        'dl_fec_id' => array('type' => 'value'),
        'ul_fec_id' => array('type' => 'value'),
        'sector_name' => array('type' => 'query', 'method' => 'sectorByName'),
        'carrier_name' => array('type' => 'query', 'method' => 'carrierByName'),
        'site_id' => array('type' => 'query', 'method' => 'searchSiteById'),
        'sector_id' => array('type' => 'value', 'field' => 'MsLogTable.sector_id'),
        'carrier_id' => array('type' => 'value', 'field' => 'MsLogTable.carrier_id'),
        'datetime' => array('type' => 'value', 'field' => 'MsLogTable.datetime'),
        'datetime_from' => array('type' => 'query', 'method' => 'filterDatetimeFrom'),
        'datetime_to' => array('type' => 'query', 'method' => 'filterDatetimeTo'),
        'retcode_id' => array('type' => 'value', 'field' => 'MsLogTable.retcode_id'),
        'om_id' => array('type' => 'value', 'field' => 'MsLogTable.om_id'),
        'comand_number' => array('type' => 'value', 'field' => 'MsLogTable.comand_number'),
    );
    
    
}

