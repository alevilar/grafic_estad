<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * Counter Model
 *
 * @property Sector $Sector
 */
class Counter extends SkpiAppModel {

    public $useDbConfig = 'migration_db';
    
     // public $useTable = 'metrics_counters';
        
    public $hasMany = array('Skpi.HourlyCounter');

    public $tablePrefix = '';

    public $hasAndBelongsToMany = array(
        'Kpi' =>
            array(
                'className' => 'Skpi.Kpi',
                'foreignKey' => 'counter_id',
                'associationForeignKey' => 'kpi_id',
            )
        );
}

