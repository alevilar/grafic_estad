<?php

App::uses('SkpiAppModel', 'Skpi.Model');

/**
 * SkyFec Model
 *
 */
class DataDay extends SkpiAppModel
{

    public $order = array('DataDay.ml_date');
    
    public $belongsTo = array('Sky.Carrier');

    public $hasMany = array('Skpi.DailyValue');


    public $actsAs = array(
        'Search.Searchable',
    );
    
    
    public $validate = array(
		'ml_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
//				'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'validateUnicoConCarrier' => array(
                                'rule'       => array('validateUnicoConCarrier'),
                                'on'         => 'create',
                                'message'    => 'Este valor debe ser único para un carrier determinado'
                        )
		),
		'carrier_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),		
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
        'date' => array('field'=>'DataDay.ml_date','type' => 'value'),
        'date_from' => array('type' => 'query', 'method' => 'filterDateFrom'),
        'date_to' => array('type' => 'query', 'method' => 'filterDateTo'),
    );
    
    public function validateUnicoConCarrier () {
        $count = $this->find('count', array(
            'conditions' => array(
                'DataDay.carrier_id' => $this->data['DataDay']['carrier_id'],
                'DataDay.ml_date' => $this->data['DataDay']['ml_date'],
            )
        ));
        return !$count;
    }

    public function filterBySite($data = array())
    {
        $conditions = array();
        if (!empty($data['site_id'])) {
            $carriers = $this->Carrier->Sector->Site->listCarriers($data['site_id']);
            $conditions = array(
                'DataDay.carrier_id' => $carriers,
            );
        }
        return $conditions;
    }

    public function filterBySector($data = array())
    {
        if (!empty($data['sector_id'])) {
            $carriers = $this->Carrier->Sector->Site->listCarriers( $data['sector_id'] );
            $conditions = array(
                'DataDay.carrier_id' => $carriers,
            );
        }
        return $data;
    }

    public function filterDateFrom($data = array())
    {
        $conditions = array();
        if (!empty($data['date_from'])) {
            $conditions = array(
                $this->name . '.ml_date >=' => $data['date_from'],
            );
        }
        return $conditions;
    }

    public function filterDateTo($data = array())
    {
        $conditions = array();
        if (!empty($data['date_to'])) {
            $conditions = array(
                $this->name . '.ml_date <=' => $data['date_to'],
            );
        }
        return $conditions;
    }
    
    
    
    public function getDayValueForSite( $kpi_id, $days = array(), $siteId = null ) {
        $siteCondition = array();
        if ( !empty($siteId ) ) {
            $siteCondition['conditions']['Site.id']  = $siteId;
        }
          
        if (!is_array($days)) {
            $days = array($days);
        }
        
        $this->Carrier->Sector->Site->recursive = -1;
        $sitios = $this->Carrier->Sector->Site->find('all', $siteCondition);
        foreach ($sitios as &$s) {
            $carriers = $this->Carrier->Sector->Site->listCarriers($s['Site']['id']);
            $s['Day'] = array();
            foreach ( $days as $day ) {
                $value = $this->DailyValue->getSumBySiteDateKpi($kpi_id, $day, $carriers);
                $s['Day'][] = $value;
            }
        }
        if ( !empty($siteId) ) {
             $sitios = $sitios[0];
        }
        return $sitios;
    }
    
    
    public function getDayValueForSector( $kpi_id, $days = array(), $sectorId = null ) {
        $sectorCondition = array();
        if ( !empty($sectorId ) ) {
            $sectorCondition['conditions']['Sector.id']  = $sectorId;
        }
          
        if (!is_array($days)) {
            $days = array($days);
        }
        
        $this->Carrier->Sector->Site->recursive = -1;
        $sectors = $this->Carrier->Sector->find('all', $sectorCondition);
        foreach ($sectors as &$s) {
            $carriers = $this->Carrier->Sector->listCarriers($sectorId);
            $s['Day'] = array();
            foreach ( $days as $day ) {
                $value = $this->DailyValue->getSumBySiteDateKpi($kpi_id, $day, $carriers);
                $s['Day'][] = $value;
            }
        }
        if (!empty($sectorId)){
             $sectors = $sectors[0];
        }
        return $sectors;
    }



    public function site_get_data_value ($site_id, $kpis, $days) {
        $kpiValues = array();        
        foreach($kpis as $k) {
            $kpiValues = $k;
            $allValues = array();
            foreach($days as $day) {
                $siteData = $this->getDayValueForSite( $k['Kpi']['id'], $day, $site_id );
                // index CERO porque siempre va a ser 1 dia que estoy recorriendo
                $allValues[] = $siteData['Day'][0];
            }
            $kpiValues[] = array('Day' => $allValues);
        }
        $this->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->Carrier->Sector->Site->read(null, $site_id);
        $site['KpiValue'] = $kpiValues;
        return $site;
    }


    public function sector_get_data_value ( $sector_id, $kpis, $days) {
        $sector_id = $what_id;
        $this->Carrier->Sector->contain(array('Site'));
        $sector = $this->Carrier->Sector->read(null, $sector_id);
        $site_id = $sector['Site']['id'];

        foreach($kpis as &$k) {
            $k['Day'] = array();
            foreach($days as $day) {
                 $siteData = $this->getDayValueForSector( $k['Kpi']['id'], $day, $sector_id );

                 // index CERO porque siempre va a ser 1 dia que estoy recorriendo
                 $k['Day'][] = $siteData['Day'][0];
            }
        }

        $this->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->Carrier->Sector->Site->read(null, $site_id);
        $site['KpiValue'] = $kpis;
        return $site;
    }


    public function carrier_get_data_value ( $carrier_id, $kpis, $days) {
        $this->Carrier->contain(array('Sector.Site'));
        $c = $this->Carrier->read(null, $carrier_id);
        $site_id = $c['Sector']['Site']['id'];
        $carriers = $c['Carrier']['id'];


        foreach($kpis as &$k) {
            $k['Day'] = array();
            foreach($days as $day) {
                $value = $this->DailyValue->getSumBySiteDateKpi( $k['Kpi']['id'], $day, $carriers );
                $k['Day'][] = $value;                
            }
        }

        // populate all site data needed
        $this->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->Carrier->Sector->Site->read(null, $site_id);
        $site['KpiValue'] = $kpis;
        return $site;
    }

    /**
    *
    *   @param string $what site, sector or carrier
    *
    **/
    public function getDataValueGeneric ( $what, $what_id, $days, $conditions) {

        $kpis = $this->DailyValue->Kpi->find('all', array('recursive'=>-1));

        $fn = $what."_get_data_value";
        return $this->{$fn}($what_id, $kpis, $days);

    }

}
