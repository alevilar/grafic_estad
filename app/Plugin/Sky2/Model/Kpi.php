<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * KpiCounter Model
 *
 * @property Sector $Sector
 */
class Kpi extends SkyAppModel {

    public $hasMany = array('Sky.DailyKpiValue');
}

