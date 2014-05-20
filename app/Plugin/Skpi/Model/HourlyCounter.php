<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class HourlyCounter extends SkpiAppModel {
    
    public $belongsTo = array(
    	'Skpi.Counter', 
    	'Sky.Carrier'
    	);
    
}

