<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class DailyKpiValue extends SkyAppModel {
    
    public $belongsTo = array('Sky.DailyKpi', 'Sky.Kpi');    
    
}

