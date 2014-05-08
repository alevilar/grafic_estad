<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class DailyKpiValue extends SkpiAppModel {
    
    public $belongsTo = array('Skpi.KpiDataDay', 'Skpi.Kpi');    
    
}

