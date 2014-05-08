<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * KpiCounter Model
 *
 * @property Sector $Sector
 */
class KpiCounter extends SkpiAppModel {

        
    public $hasMany = array('Skpi.KpiHourlyCounter');
}

