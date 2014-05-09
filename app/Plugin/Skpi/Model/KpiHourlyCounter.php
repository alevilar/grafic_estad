<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class KpiHourlyCounter extends SkpiAppModel {
    
    public $belongsTo = array('Skpi.KpiCounter', 'Sky.Carrier');
    
}

