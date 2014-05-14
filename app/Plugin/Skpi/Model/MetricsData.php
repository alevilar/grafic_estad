<?php
App::uses('AppModel', 'Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class MetricsData extends AppModel {
    
    public $useDbConfig = 'migration_db';
    
    public $useTable = 'metrics_data';
    
    
    
}

