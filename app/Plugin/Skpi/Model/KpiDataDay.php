<?php

App::uses('SkyAppModel', 'Sky.Model');

/**
 * SkyFec Model
 *
 */
class KpiDataDay extends SkyAppModel
{

    public $order = array('KpiDataDay.ml_date');
    
    public $belongsTo = array('Sky.Carrier');
    public $hasMany = array('Skpi.KpiDailyValue');
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
        'date' => array('field'=>'KpiDataDay.ml_date','type' => 'value'),
        'date_from' => array('type' => 'query', 'method' => 'filterDateFrom'),
        'date_to' => array('type' => 'query', 'method' => 'filterDateTo'),
    );

    public function filterBySite($data = array())
    {
        $conditions = array();
        if (!empty($data['site_id'])) {
            $conditions = array(
                'Site.id' => $data['site_id'],
            );
        }
        return $conditions;
    }

    public function filterBySector($data = array())
    {
        if (!empty($data['sector_id'])) {
            $carriers = $this->KpiDailyValue->Carrier->Sector->Sitio->listCarriers( $data['sector_id'] );
            $conditions = array(
                'KpiDailyValue.carrier_id' => $carriers,
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
    
    
    
    public function getSumValueForSite( $kpi_id, $days = array(), $siteId = null ) {
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
                $value = $this->KpiDailyValue->getSumBySiteDateKpi($kpi_id, $day, $carriers);
                $s['Day'][] = $value;
            }
        }
        if (!empty($siteId)){
             $sitios = $sitios[0];
        }
        return $sitios;
    }

}
