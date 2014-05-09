<?php

App::uses('SkpiAppController', 'Skpi.Controller');

class KpiDataDaysController extends SkpiAppController
{
    public $helpers = array(
        'Skpi.Kpi',
    );

    public $components = array(
        'RequestHandler',
        'Search.Prg',
    );

    /**
     * Preset Variable Search
     *
     * @var array
     * @access public
     */
    public $presetVars = true;
    

    public function graf_max_uldl_de_sitio( $sitio_id )
    {
        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);

        if (!empty($conditions['Site.id'])) {
            $sitio_id = $conditions['Site.id'];
        }

        if (empty($conditions['KpiDataDay.ml_date <='])) {
            $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.ml_date >='])) {
            $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        }

        
        $conditions['KpiDataDay.carrier_id IN'] = $this->KpiDataDay->Carrier->Sector->Site->listCarriers($sitio_id);
        $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime('now'));

        $days = $this->KpiDataDay->find('list', array(
                'conditions' => $conditions,
                'group' => 'KpiDataDay.ml_date',
                'fields' => array('ml_date', 'ml_date')
        ));
        

        $sitiosDl = $this->KpiDataDay->getDayValueForSite( SK_KPI_MAX_DL_ID, $days, $sitio_id);
        $sitiosUl = $this->KpiDataDay->getDayValueForSite( SK_KPI_MAX_UL_ID, $days, $sitio_id);
        

        if (!empty($conditions['KpiDataDay.ml_date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.ml_date <='];
        }

        if (!empty($conditions['KpiDataDay.ml_date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.ml_date >='];
        }

        $this->KpiDataDay->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->KpiDataDay->Carrier->Sector->Site->read(null, $sitio_id);
        $this->set('title_for_layout', $site['Site']['name']);

        $this->set('sites', $this->KpiDataDay->Carrier->Sector->Site->find('list'));

        $cleanKpisDl = array();
        $cleanKpisUl = array();
        foreach ($sitiosDl['Day'] as $byDay) {
                $cleanKpisDl[] = array(
                    $byDay['KpiDataDay']['ml_date'],
                    $byDay[0]['valor'],
                );
        }
        
        foreach ($sitiosUl['Day'] as $byDay) {
                $cleanKpisUl[] = array(
                    $byDay['KpiDataDay']['ml_date'],
                    $byDay[0]['valor'],
                );
        }
               

        $this->set('sitio', $site);
        $this->request->data['KpiDataDay']['site_id'] = $sitio_id;
        $this->set('kpis', array(array_values($cleanKpisDl), array_values($cleanKpisUl)));
        //	$this->set('_serialize', array('kpis', 'sitio', 'title_for_layout'));
    }

    public function kpi_values_x_sitio( $kpi_id = SK_KPI_MAX_DL_ID )
    {
        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);


        $days = $this->__getDays($conditions);

        $sitios = $this->KpiDataDay->getDayValueForSite( $kpi_id, $days);
        

        $kpi = $this->KpiDataDay->KpiDailyValue->Kpi->read(null, $kpi_id);
        $this->set('kpi', $kpi);
        $this->set('days', array_values($days));
        $this->set('sites_list', $this->KpiDataDay->Carrier->Sector->Site->find('list'));
        $this->set('title_for_layout', $kpi['Kpi']['name']." por Sitio");
        $this->set('kpis', $sitios);
    }

    
    
    private function __getDays($conditions,  $dateFrom = null, $dateTo = null){
        if (empty($conditions['KpiDataDay.ml_date <=']) && !empty($dateTo)) {
            $conditions['KpiDataDay.ml_date <='] = $dateTo;
        }

        if ( empty($conditions['KpiDataDay.ml_date >=']) && !empty($dateFrom)) {
            $conditions['KpiDataDay.ml_date >='] = $dateFrom;
        }
        
        if (empty($conditions['KpiDataDay.ml_date <='])) {
            $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.ml_date >='])) {
            $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        }      
        
        $days = $this->KpiDataDay->find('list', array(
                'conditions' => $conditions,
                'group' => 'KpiDataDay.ml_date',
                'fields' => array('ml_date', 'ml_date')
        ));
        
        if (!empty($conditions['KpiDataDay.ml_date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.ml_date <='];
        }

        if (!empty($conditions['KpiDataDay.ml_date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.ml_date >='];
        }
        $this->set('days', $days);
        
        return $days;
    }

    
    
    private function __by( $what = 'site', $carriers = array(), $dateFrom = null, $dateTo = null) {
        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);
        
        if (!empty($this->request->query['site_id'])) {
            $this->site_id = $this->request->query['site_id'];
        }
        $days = $this->__getDays($conditions, $dateFrom, $dateTo);
        $kpis = $this->KpiDataDay->KpiDailyValue->Kpi->find('all', array('recursive'=>-1));
        
        $conditions['KpiDataDay.carrier_id'] = $carriers;
               
        switch ( $what) {
            case 'site':
                foreach($kpis as &$k) {
                    $k['Day'] = array();
                    foreach($days as $day) {
                         $siteData = $this->KpiDataDay->getDayValueForSite( $k['Kpi']['id'], $day, $this->site_id );
                        // index CERO porque siempre va a ser 1 dia que estoy recorriendo
                        $k['Day'][] = $siteData['Day'][0];
                    }
                }
                break;
            case 'sector': 
                foreach($kpis as &$k) {
                    $k['Day'] = array();
                    foreach($days as $day) {
                         $siteData = $this->KpiDataDay->getSumValueForSector( $k['Kpi']['id'], $day, $this->sector_id );

                         // index CERO porque siempre va a ser 1 dia que estoy recorriendo
                         $k['Day'][] = $siteData['Day'][0];
                    }
                }
                break;

            case 'carrier':
                foreach($kpis as &$k) {
                    $k['Day'] = array();
                    foreach($days as $day) {
                        $value = $this->KpiDataDay->KpiDailyValue->getSumBySiteDateKpi( $k['Kpi']['id'], $day, $carriers );
                        $k['Day'][] = $value;                
                    }
                }
                break;
        }
        
        
        $this->KpiDataDay->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->KpiDataDay->Carrier->Sector->Site->read(null, $this->site_id);
        $sites_list = $this->KpiDataDay->Carrier->Sector->Site->find('list');
        $this->set('title_for_layout', "Sitio: " . $site['Site']['name']);
        $this->request->data['KpiDataDay']['site_id'] = $this->site_id;
        $this->set('site', $site);
        $this->set('sites_list', $sites_list);
        $this->set('kpis', $kpis);
        
    }
    
    /**
     *  KPI por sitio
     * */
    public function by_site($sitio_id = null, $dateFrom = null, $dateTo = null)
    {    
        $this->site_id = $sitio_id;
        $carriers = $this->KpiDataDay->Carrier->Sector->Site->listCarriers($sitio_id);;
        $this->__by('site', $carriers, $dateFrom, $dateTo);        
    }

    /**
     *  KPI por sector
     * */
    public function by_sector($sector_id = null, $dateFrom = null, $dateTo = null)
    {
        $this->sector_id = $sector_id;
        $this->KpiDataDay->Carrier->Sector->contain(array('Site'));
        $sector = $this->KpiDataDay->Carrier->Sector->read(null, $sector_id);
        $this->site_id = $sector['Site']['id'];
        $carriers = $this->KpiDataDay->Carrier->Sector->listCarriers($sector_id);
        $this->__by('sector', $carriers, $dateFrom, $dateTo);
        $this->render('by_site');
    }

    /**
     *  KPI por carrier
     * */
    public function by_carrier($carrier_id, $dateFrom = null, $dateTo = null)
    {
        $this->KpiDataDay->Carrier->contain(array('Sector.Site'));
        $c = $this->KpiDataDay->Carrier->read(null, $carrier_id);
        $this->site_id = $c['Sector']['Site']['id'];
        $this->__by('carrier', $carrier_id, $dateFrom, $dateTo);
        $this->render('by_site');
    }

}

