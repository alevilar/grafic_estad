<?php

App::uses('SkpiAppController', 'Skpi.Controller');

class DataDaysController extends SkpiAppController
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
    

    public function graf_max_uldl_de_sitio( $site_id )
    {
        $this->Prg->commonProcess();
        $conditions = $this->DataDay->parseCriteria($this->request->query);

        if (!empty($conditions['Site.id'])) {
            $site_id = $conditions['Site.id'];
        }

        if (empty($conditions['DataDay.ml_date <='])) {
            $conditions['DataDay.ml_date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['DataDay.ml_date >='])) {
            $conditions['DataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        }

        
        $conditions['DataDay.carrier_id IN'] = $this->DataDay->Carrier->Sector->Site->listCarriers($site_id);
        $conditions['DataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        $conditions['DataDay.ml_date <='] = date('Y-m-d', strtotime('now'));

        $days = $this->DataDay->find('list', array(
                'conditions' => $conditions,
                'group' => 'DataDay.ml_date',
                'fields' => array('ml_date', 'ml_date')
        ));
        

        $sitiosDl = $this->DataDay->getDayValueForSite( SK_KPI_MAX_DL_ID, $days, $site_id);
        $sitiosUl = $this->DataDay->getDayValueForSite( SK_KPI_MAX_UL_ID, $days, $site_id);
        

        if (!empty($conditions['DataDay.ml_date <='])) {
            $this->request->data['DataDay']['date_to'] = $conditions['DataDay.ml_date <='];
        }

        if (!empty($conditions['DataDay.ml_date >='])) {
            $this->request->data['DataDay']['date_from'] = $conditions['DataDay.ml_date >='];
        }

        $this->DataDay->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->DataDay->Carrier->Sector->Site->read(null, $site_id);
        $this->set('title_for_layout', $site['Site']['name']);

        $this->set('sites', $this->DataDay->Carrier->Sector->Site->find('list'));

        $cleanKpisDl = array();
        $cleanKpisUl = array();
        foreach ($sitiosDl['Day'] as $byDay) {
                $cleanKpisDl[] = array(
                    $byDay['DataDay']['ml_date'],
                    $byDay[0]['valor'],
                );
        }
        
        foreach ($sitiosUl['Day'] as $byDay) {
                $cleanKpisUl[] = array(
                    $byDay['DataDay']['ml_date'],
                    $byDay[0]['valor'],
                );
        }
               

        $this->set('sitio', $site);
        $this->request->data['DataDay']['site_id'] = $site_id;
        $this->set('kpis', array(array_values($cleanKpisDl), array_values($cleanKpisUl)));
        //	$this->set('_serialize', array('kpis', 'sitio', 'title_for_layout'));
    }


    public function monitor( )
    {
        $this->set('sites', $this->DataDay->Carrier->Sector->Site->find('list'));
        $this->set('title_for_layout', "Monitor de Estado");
    }

    public function site_kpi_detail( $site_id, $kpi_id = SK_KPI_MAX_DL_ID,  $date_from = null, $date_to = null )
    {
        $this->Prg->commonProcess();
        $conditions = $this->DataDay->parseCriteria($this->request->query);


        if ( empty($date_from) ) {
            $date_from = date('Y-m-d', strtotime('-3 day'));
        }

        
        $sites_list = $this->DataDay->Carrier->Sector->Site->find('list');

        
        $days = $this->__getDays($conditions, $date_from, $date_to);

        $kpis = $this->DataDay->DailyValue->Kpi->find('all', array(
            'recursive'=>-1,
            'conditions' => array(
                    'Kpi.id' => $kpi_id
                )
            ));

        $kpis = $this->DataDay->site_get_data_value($site_id, $kpis, $days);


        $kpi = $this->DataDay->DailyValue->Kpi->read(null, $kpi_id);


        $this->set('kpis', $kpis['KpiValue']);
        $this->set('site', $kpis);
        $this->set('kpi', $kpi);
        $this->set('sites_list', $sites_list);
        $this->set('title_for_layout', "Detalles del KPI ".$kpi['Kpi']['name']." para el Sitio: " . $kpis['Site']['name']);


        // para calcular los graficos
        $graph_date_from = date('Y-m-d', strtotime('-1 month'));
        $graph_date_to = date('Y-m-d');

        // Get DataCounter Model
        $DataCounter = ClassRegistry::init('Skpi.DataCounter');
        // set        
        $counters = array();
        foreach ($kpi['Counter'] as $counter) {
            $counters[] = $DataCounter->getDataForSiteCounter($site_id, $counter['id'], $graph_date_from, $graph_date_to);    
        }

        $this->set(compact('counters'));
        
    }

    
    
    private function __getDays($conditions,  $dateFrom = null, $dateTo = null){
        if (empty($conditions['DataDay.ml_date <=']) && !empty($dateTo)) {
            $conditions['DataDay.ml_date <='] = $dateTo;
        }

        if ( empty($conditions['DataDay.ml_date >=']) && !empty($dateFrom)) {
            $conditions['DataDay.ml_date >='] = $dateFrom;
        }
        
        if (empty($conditions['DataDay.ml_date <='])) {
            $conditions['DataDay.ml_date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['DataDay.ml_date >='])) {
            $conditions['DataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        }      
        
        $days = $this->DataDay->find('list', array(
                'conditions' => $conditions,
                'group' => 'DataDay.ml_date',
                'fields' => array('ml_date', 'ml_date')
        ));
        
        if (!empty($conditions['DataDay.ml_date <='])) {
            $this->request->data['DataDay']['date_to'] = $conditions['DataDay.ml_date <='];
        }

        if (!empty($conditions['DataDay.ml_date >='])) {
            $this->request->data['DataDay']['date_from'] = $conditions['DataDay.ml_date >='];
        }
        $this->set('days', $days);
        
        return $days;
    }



    public function view ( $what = 'site', $what_id, $date_from = null, $date_to = null ) {
        $this->Prg->commonProcess();
        $conditions = $this->DataDay->parseCriteria($this->request->query);


        if ( empty($date_from) ) {
            $date_from = date('Y-m-d', strtotime('-3 day'));
        }

        
        $sites_list = $this->DataDay->Carrier->Sector->Site->find('list');

        
        $days = $this->__getDays($conditions, $date_from, $date_to);

        
        // get values
        $kpis = $this->DataDay->getDataValueGeneric($what, $what_id, $days, $conditions);

        $this->set('kpis', $kpis['KpiValue']);
        $this->set('site', $kpis);
        $this->set('sites_list', $sites_list);
        $this->set('title_for_layout', "Sitio: " . $kpis['Site']['name']);


        // para calcular los graficos
        $graph_date_from = date('Y-m-d', strtotime('-1 month'));
        $graph_date_to = date('Y-m-d');

        // Get DataCounter Model
        $DataCounter = ClassRegistry::init('Skpi.DataCounter');
        // set        
        $metricsDl = $DataCounter->getDataForSiteCounter($what_id, SK_COUNTER_DL_AVG, $graph_date_from, $graph_date_to);
        $metricsUl = $DataCounter->getDataForSiteCounter($what_id, SK_COUNTER_UL_AVG, $graph_date_from, $graph_date_to);

        $this->set(compact('metricsDl','metricsUl'));


    }

}

