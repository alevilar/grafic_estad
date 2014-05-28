<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * Counter Model
 *
 * @property Sector $Sector
 */
class Counter extends SkpiAppModel {

        
    public $hasMany = array('Skpi.HourlyCounter');

    public $hasAndBelongsToMany = array(
        'Kpi' =>
            array(
                'className' => 'Skpi.Kpi',
                'foreignKey' => 'counter_id',
                'joinTable' => 'skpi_counters_kpis',
                'associationForeignKey' => 'kpi_id',
            )
        );
}

