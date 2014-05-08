<?php
App::uses('SkyAppModel', 'Sky.Model');
/**
 * SkyFec Model
 *
 */
class DailyKpi extends SkyAppModel {

    public $belongsTo = array('Sky.Carrier');
    
    
    public $hasMany = array('Sky.DailyKpiValue');
    

    public $actsAs = array(
        'Search.Searchable',
    );



	/**
     * Filter search fields
     *
     * @var array
     * @access public
     */
    public $filterArgs = array(        
        'site_id' => array('type' => 'query', 'method' => 'filterBySite'),
		'sector_id' => array('type' => 'query', 'method' => 'filterBySector'),
		'carrier_id' => array('type' => 'value'),    
		'date' => array('type' => 'value'),  
        'date_from' => array('type' => 'query', 'method' => 'filterDateFrom'),
        'date_to' => array('type' => 'query', 'method' => 'filterDateTo'),
    );



	public function beforeFind ( $query ) {		
		
		if  ( empty($query['contain']) || ( empty($query['recursive']) || $query['recursive'] < 1 ) ){
			$query['recursive'] = 3;
			$query['joins'] = array(
				array(
			    	'table' => 'sky_carriers',
			        'alias' => 'Carrier2',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Carrier2.id = DateKpi.carrier_id',
			        )
			    ),
			    array(
			    	'table' => 'sky_sectors',
			        'alias' => 'Sector',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Sector.id = Carrier2.sector_id',
			        )
			    ),
			    array(
			    	'table' => 'sky_sites',
			        'alias' => 'Site',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Site.id = Sector.site_id',
			        )
			    )
			);	
		}
				
		return $query;
	}


	public function filterBySite($data = array()) {
		$conditions = array();
        if (!empty($data['site_id'])) {
            $conditions = array(
                'Site.id' => $data['site_id'],
            );
        }
        return $conditions;
	}

	public function filterBySector($data = array()) {
		$conditions = array();
        if (!empty($data['sector_id'])) {
            $conditions = array(
                'Sector.id' => $data['sector_id'],
            );
        }
        return $conditions;
	}

    public function filterDateFrom($data = array())
    {
        $conditions = array();
        if (!empty($data['date_from'])) {
            $conditions = array(
                $this->name.'.date >=' => $data['date_from'],
            );
        }
        return $conditions;
    }



    public function filterDateTo($data = array())
    {
        $conditions = array();
        if (!empty($data['date_to'])) {
            $conditions = array(
                $this->name.'.date <=' => $data['date_to'],
            );
        }
        return $conditions;
    }

}
