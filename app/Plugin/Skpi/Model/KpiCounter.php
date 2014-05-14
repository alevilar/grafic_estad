<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * KpiCounter Model
 *
 * @property Sector $Sector
 */
class KpiCounter extends SkpiAppModel {

    public $useDbConfig = 'migration_db';
    
    public $useTable = 'metrics_counters';
        
    public $hasMany = array('Skpi.KpiHourlyCounter');
}

