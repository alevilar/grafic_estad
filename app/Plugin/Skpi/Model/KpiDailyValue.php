<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class KpiDailyValue extends SkpiAppModel {

    
    public $belongsTo = array('Skpi.KpiDataDay', 'Skpi.Kpi');    
    
    
    /**
     * Returns the SUM of Daily Value of one Site per one specific DAY and KPI
     * 
     * @param type $kpiId
     * @param type $day of type date
     * @param type $carriers array of carriers id´s
     */
    public function getSumBySiteDateKpi($kpiId, $day, $carriers = array() ) {        
        return $this->KpiDataDay->KpiDailyValue->find('first', array(
                        'conditions' => array(
                            'KpiDailyValue.kpi_id' => $kpiId,
                            'KpiDataDay.ml_date' => $day,
                            'KpiDataDay.carrier_id' => $carriers,
                        ),
                        'contain' => array(
                            'KpiDataDay',
                            'Kpi',
                        ),
                        'fields' => array(
                            'AVG(KpiDailyValue.value) as valor',
                            'KpiDataDay.ml_date',
                            'Kpi.*',
                        ),
                    ));
    }
    
}

