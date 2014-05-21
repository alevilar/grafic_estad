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
    





    /**
    *
    *
    *       Monitor es una pagina que rota los diferentes sitios mostrando informacion basica
    *       Esta accion solo lista los Sitios, cuya informacion sera cargada mediante ajax
    *
    *
    */  
    public function monitor( )
    {
        $this->set('sites', $this->DataDay->Carrier->Sector->Site->find('list'));
        $this->set('title_for_layout', "Monitor de Estado");
    }



    /**
    *
    *
    *       Detalle para un KPI particular y un Sitio
    *       Esta accion muestra los datos del Sitio, Sectoy y Carrier
    *
    *
    */  
    public function site_kpi_detail( $site_id, $kpi_id = SK_KPI_MAX_DL_ID,  $date_from = null, $date_to = null )
    {
        $this->Prg->commonProcess();
        $conditions = $this->DataDay->parseCriteria($this->request->query);


        if ( empty($date_from) ) {
            $date_from = date('Y-m-d', strtotime('-3 day'));
        }

        
        $sites_list = $this->DataDay->Carrier->Sector->Site->find('list');

        
        $days = $this->__getDays($conditions, $date_from, $date_to);
      
        $site = $this->DataDay->Carrier->Sector->Site->readCarrier( $site_id );

        $siteKpisValues = $this->DataDay->generic_get_day_value_for_kpi('site', $kpi_id, $days, $site_id);
        $siteKpisValues['Title'] = array(
            $siteKpisValues['Site']['name'],
            'site',
            );


        $kpiValues = array($siteKpisValues);
        foreach ( $site['Sector'] as $sec ) {
            $a = $this->DataDay->generic_get_day_value_for_kpi('sector', $kpi_id, $days, $sec['id']);
            $a['Title'] = array(
                '&nbsp;&nbsp;Sector: '. $a['Sector']['name'],
                'sector',
                );
            $kpiValues[] = $a;
            foreach ($sec['Carrier'] as $carr ) {
                $a = $this->DataDay->generic_get_day_value_for_kpi('carrier', $kpi_id, $days, $carr['id']);
                $a['Title'] = array(
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier: '.$a['Carrier']['name'],
                    'carrier',
                    );
                $kpiValues[] = $a;
            }
        }


        $kpi = $this->DataDay->DailyValue->Kpi->read(null, $kpi_id);


        $this->set(compact('kpiValues', 'kpi', 'site', 'sites_list'));
        $this->set('title_for_layout', "Detalles del KPI ".$kpi['Kpi']['name']." para el Sitio: " . $site['Site']['name']);


        // para calcular los graficos
        $graph_date_from = date('Y-m-d', strtotime('-1 month'));
        $graph_date_to = date('Y-m-d');

        // Get DataCounter Model
        $DataCounter = ClassRegistry::init('Skpi.DataCounter');
        // set        
        $counters = array();
        foreach ($kpi['Counter'] as $counter) {
            $counters[] = $DataCounter->getDataCounter('site', $site_id, $counter['id'], $graph_date_from, $graph_date_to);    
        }

        $this->set(compact('counters'));
        
    }



    /**
    *
    *
    *       Ver informacion para un sitio en particular
    *       Esta accion muestra los datos del todos los KPI´s para un sitio en particular
    *
    *
    */  
    public function view ( $what = 'site', $what_id, $date_from = null, $date_to = null ) {
        $this->Prg->commonProcess();
        $conditions = $this->DataDay->parseCriteria($this->request->query);


        if ( empty($date_from) ) {
            $date_from = date('Y-m-d', strtotime('-3 day'));
        }

        
        $sites_list = $this->DataDay->Carrier->Sector->Site->find('list');

        
        $days = $this->__getDays($conditions, $date_from, $date_to);

        
        // get values
        $kpiValues = $this->DataDay->generic_get_data_value($what, $what_id, $days, $conditions);

        $site = $this->DataDay->Carrier->Sector->Site->readCarrier( $kpiValues['Site']['id'] );


        $this->set( compact( 'sites_list', 'site', 'kpiValues' ) );
        $this->set('title_for_layout', "Sitio: " . $site['Site']['name']);

        // para calcular los graficos
        $graph_date_from = date('Y-m-d', strtotime('-1 month'));
        $graph_date_to = date('Y-m-d');

        // Get DataCounter Model
        $DataCounter = ClassRegistry::init('Skpi.DataCounter');
        // set        
        $metricsDl = $DataCounter->getDataCounter($what, $what_id, SK_COUNTER_DL_AVG, $graph_date_from, $graph_date_to);
        $metricsUl = $DataCounter->getDataCounter($what, $what_id, SK_COUNTER_UL_AVG, $graph_date_from, $graph_date_to);

        $this->set(compact('metricsDl','metricsUl'));


    }









    /**
    *
    *
    *       Recoge los valores que vienen desde el formulario, parametros o paginador
    *       y busca el rango en el model DataDay
    *       Con el objetivo de poder agrupar los distintos medios en los que vienen esos datos
    *   
    *   @param array $conditions son los que vienen luego del Search Plugin
    *   @param string $dateFrom formato fecha "Y-m-d"
    *   @param string $dateTo formato fecha "Y-m-d"
    *   @return array find('all') de fechas del model DataDay
    */  
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



}

