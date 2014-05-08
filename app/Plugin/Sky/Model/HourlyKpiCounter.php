<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class HourlyKpiCounter extends SkyAppModel {
    
    public $belongsTo = array('Sky.KpiCounter');
    
}

