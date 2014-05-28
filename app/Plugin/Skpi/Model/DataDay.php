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

    
    
    
    /**
    *
    *   Devuelve un array de sitios para un KPI dado y para un rango de fechas
    *   Se le puede pasar un array de condiciones que será utilizado en la busqueda de Sitio.
    *   También se puede pasar directamente un ID como condicion de búsqueda, en ese caso pasa como ID de Sitio
    *   
    *   
    *   @param $integer kpi_id
    *   @param array $days array de fechas
    *   @param array $siteConditions array de condiciones. Si se pasa un numero es tenido en cuenta como el id del sitio
    *                                               
    *
    **/
    public function site_list_get_day_value_for_kpi( $kpi_id, $days = array(), $conditions = array() ) {        
        if ( is_numeric($conditions) ) {
            $ops['conditions']['Site.id']  = $conditions;
        } else {
            $ops['conditions']  = $conditions;
        }
          
        if (!is_array($days)) {
            $days = array($days);
        }
        $this->Carrier->Sector->Site->recursive = -1;
        $sitios = $this->Carrier->Sector->Site->find('all', $ops);
        foreach ($sitios as &$s) {
            $carriers = $this->Carrier->Sector->Site->listCarriers($s['Site']['id']);
            $s['Day'] = array();
            foreach ( $days as $day ) {
                $value = $this->DailyValue->getSumBySiteDateKpi($kpi_id, $day, $carriers);
                $s['Day'][] = $value;
            }
        }

        if ( is_numeric($conditions) ) {
            $sitios = $sitios[0];
        }

        return $sitios;
    }
    
    
    public function sector_list_get_day_value_for_kpi( $kpi_id, $days = array(), $conditions = null ) {
        if ( !empty($conditions ) && is_numeric($conditions) ) {
            $ops['conditions']['Sector.id']  = $conditions;
        } else {
            $ops['conditions']  = $conditions;
        }
          
        if (!is_array($days)) {
            $days = array($days);
        }
        
        $this->Carrier->Sector->Site->recursive = -1;
        $sectors = $this->Carrier->Sector->find('all', $ops);
        foreach ($sectors as &$s) {
            $carriers = $this->Carrier->Sector->listCarriers($s['Sector']['id']);
            $s['Day'] = array();
            foreach ( $days as $day ) {
                $value = $this->DailyValue->getSumBySiteDateKpi($kpi_id, $day, $carriers);
                $s['Day'][] = $value;
            }
        }

        if ( is_numeric($conditions) ) {
            $sectors = $sectors[0];
        }

        return $sectors;
    }


    public function carrier_list_get_day_value_for_kpi( $kpi_id, $days, $conditions ) {
        if ( !empty($conditions ) && is_numeric($conditions) ) {
            $ops['conditions']['Carrier.id']  = $conditions;
        } else {
            $ops['conditions']  = $conditions;
        }
          
        if (!is_array($days)) {
            $days = array($days);
        }

        $this->Carrier->recursive = -1;
        $carriers = $this->Carrier->find('all', $ops);

        foreach ($carriers as &$c) {            
            $c['Day'] = array();
            foreach ( $days as $day ) {
                $value = $this->DailyValue->getSumBySiteDateKpi($kpi_id, $day, $c['Carrier']['id']);
                $c['Day'][] = $value;
            }
        }

        if ( is_numeric($conditions) ) {
            $carriers = $carriers[0];
        }

        return $carriers;
    }

    public function generic_get_day_value_for_kpi( $what = 'site', $what_id, $days, $conditions ) {
        $fn = $what.'_list_get_day_value_for_kpi';
        return $this->{$fn}( $what_id, $days, $conditions );
    }


    public function generic_all_kpis_per_day_value ( $what = 'site', $what_id, $kpis, $days) {        
        $kpiValues = array();
        foreach($kpis as $k) {            
            $allValues = array();
            foreach($days as $day) { 
                $siteData = $this->generic_get_day_value_for_kpi($what, $k['Kpi']['id'], $day, $what_id );
                // index CERO porque siempre va a ser 1 dia que estoy recorriendo
                $allValues[] = $siteData['Day'][0];
            }
            $k['Day'] = $allValues;
            $kpiValues[] = $k;
        }
        
        return $kpiValues;   
    }



    public function site_get_data_value ($site_id, $kpis, $days) {
        $kpiValues = $this->generic_all_kpis_per_day_value('site', $site_id, $kpis, $days);
        $site = $this->Carrier->Sector->Site->readCarrier( $site_id);
        $site['KpiValue'] = $kpiValues;

        return $site;
    }


    public function sector_get_data_value ( $sector_id, $kpis, $days) {
        $this->Carrier->Sector->contain(array('Site'));
        $sector = $this->Carrier->Sector->read(null, $sector_id);
        $site_id = $sector['Site']['id'];

        $kpiValues = $this->generic_all_kpis_per_day_value('sector', $sector_id, $kpis, $days);

        $site = $this->Carrier->Sector->Site->readCarrier( $site_id);
        $site['KpiValue'] = $kpiValues;
        return $site;
    }


    public function carrier_get_data_value ( $carrier_id, $kpis, $days) {
        $this->Carrier->contain(array('Sector.Site'));
        $c = $this->Carrier->read(null, $carrier_id);
        $site_id = $c['Sector']['Site']['id'];

        $kpiValues = $this->generic_all_kpis_per_day_value('carrier', $carrier_id, $kpis, $days);

        // populate all site data needed
        $this->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->Carrier->Sector->Site->read(null, $site_id);
        $site['KpiValue'] = $kpiValues;
        return $site;
    }

    /**
    *
    *   @param string $what site, sector or carrier
    *
    **/
    public function generic_get_data_value ( $what, $what_id, $days, $conditions) {

        $kpis = $this->DailyValue->Kpi->find('all', array('recursive'=>-1));
        $fn = $what."_get_data_value";
        return $this->{$fn}($what_id, $kpis, $days);

    }

}
