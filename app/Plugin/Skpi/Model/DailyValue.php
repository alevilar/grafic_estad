<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class DailyValue extends SkpiAppModel {

    /**
    * Display field
    *
    * @var string
    */
        public $displayField = 'kpi_id';

    
    public $belongsTo = array('Skpi.DataDay', 'Skpi.Kpi');    
    
    
    /**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'data_day_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'kpi_id' => array(
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
     * Returns the SUM of Daily Value of one Site per one specific DAY and KPI
     * 
     * @param type $kpiId
     * @param type $day of type date
     * @param type $carriers array of carriers id´s
     */
    public function getSumBySiteDateKpi($kpiId, $day, $carriers = array() ) {        
        $dd = $this->DataDay->DailyValue->find('first', array(
                        'conditions' => array(
                            'DailyValue.kpi_id' => $kpiId,
                            'DataDay.ml_date' => $day,
                            'DataDay.carrier_id' => $carriers,
                        ),
                        'contain' => array(
                            'DataDay',
                            'Kpi',
                        ),
                        'fields' => array(
                            'AVG(DailyValue.value) as valor',
                            'DataDay.ml_date',
                            'Kpi.*',
                        ),
                    ));

        return $dd;
    }
    
}

