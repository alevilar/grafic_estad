<?php

App::uses('SkpiAppController', 'Skpi.Controller');
/**
 * KpiCounters Controller
 *
 * @property Counter $Counter
 * @property PaginatorComponent $Paginator
 */
class SiteMaximsDailyValuesController extends SkpiAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
        'RequestHandler',
        'Search.Prg',
    );


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
    *   @param array $ops opciones adicionales puede llevar como opcion
    *                       'defaultDateFrom'
    *                       'defaultDateTo'
    *   @return array find('all') de fechas del model DataDay
    */  
    private function __getDays($conditions,  $dateFrom = null, $dateTo = null, $ops = array()){

        $model = $this->modelClass;
        $defaultDateTo = date('Y-m-d', strtotime('now'));
        $defaultDateFrom = date('Y-m-d', strtotime('-1 week'));

        if ( !empty ($ops['defaultDateTo']) ) {
            $defaultDateTo = $ops['defaultDateTo'];
        }

        if ( !empty ($ops['defaultDateFrom']) ) {
            $defaultDateFrom = $ops['defaultDateFrom'];
        }

        if (empty($conditions[$model.'.ml_datetime <=']) && !empty($dateTo)) {
            $conditions[$model.'.ml_datetime <='] = $dateTo;
        }

        if ( empty($conditions[$model.'.ml_datetime >=']) && !empty($dateFrom)) {
            $conditions[$model.'.ml_datetime >='] = $dateFrom;
        }
        
        if (empty($conditions[$model.'.ml_datetime <='])) {
            $conditions[$model.'.ml_datetime <='] = $defaultDateTo;
        }

        if (empty($conditions[$model.'.ml_datetime >='])) {
            $conditions[$model.'.ml_datetime >='] = $defaultDateFrom;
        }      
        
        
        if (!empty($conditions[$model.'.ml_datetime <='])) {
            $this->request->data[$model.'']['date_to'] = $conditions[$model.'.ml_datetime <='];
        }

        if (!empty($conditions[$model.'.ml_datetime >='])) {
            $this->request->data[$model.'']['date_from'] = $conditions[$model.'.ml_datetime >='];
        }
        
        return array(
				$conditions[$model.'.ml_datetime >='],
				$conditions[$model.'.ml_datetime <='],
        	);
    }

	public function monitor ( $date_from = null, $date_to = null ) {
        if ( empty($this->request->params['ext']) || $this->request->params['ext'] != 'xls') {
            $this->layout = 'clean';
        }
        $this->set('title_for_layout', 'Máximo tráfico por Radiobase');
		$this->Prg->commonProcess();
        $conditions = $this->SiteMaximsDailyValue->parseCriteria($this->request->query);
        $busqueda = false;
        if (!empty($conditions)) {
            $busqueda = true;
        }        
        $days = $this->__getDays($conditions, $date_from, $date_to, array(
        		'defaultDateFrom' =>   date('Y-m-d', strtotime('-3 day')),
        		'defaultDateTo' =>   date('Y-m-d'),
        	));

		$sitesMaxims = $this->SiteMaximsDailyValue->getSitesValues($days[0], $days[1]);

		$sites = $this->SiteMaximsDailyValue->Site->find('list');
        $days = array_values(crear_fechas($days[0], $days[1]));
		$this->set(compact('sitesMaxims', 'sites', 'busqueda', 'days'));
	}




	public function graph_jplot ( $site_id  = null, $date_from = null, $date_to = null) {
        $this->Prg->commonProcess();
        $conditions = $this->SiteMaximsDailyValue->parseCriteria($this->request->query);

        $days = $this->__getDays($conditions, $date_from, $date_to, array(
                'defaultDateFrom' =>   date('Y-m-d', strtotime('-1 week')),
                'defaultDateTo' =>   date('Y-m-d'),
            ));		

        $siteName = 'Toda la Red';
        $siteVals = $this->SiteMaximsDailyValue->getSiteValue( $days[0], $days[1], $site_id);
        
        if ( !empty($site_id) ) {
            $this->SiteMaximsDailyValue->Site->recursive = -1;        
            $site = $this->SiteMaximsDailyValue->Site->read(null, $site_id);
            $siteName = $site['Site']['name'];
        }

		$metricsDl = $metricsUl = array();
		foreach ($siteVals as $data) {
			$metricsDl[] = array(
                $data['SiteMaximsDailyValue']['ml_datetime'], 
                $data['SiteMaximsDailyValue']['dl_value'],
                sprintf('%0.3G',$data['SiteMaximsDailyValue']['dl_value']) ." (" .date('H:i', strtotime($data['SiteMaximsDailyValue']['ml_datetime'])).")",
                );
			$metricsUl[] = array(
                $data['SiteMaximsDailyValue']['ml_datetime'], 
                $data['SiteMaximsDailyValue']['ul_value'],
                sprintf('%0.3G',$data['SiteMaximsDailyValue']['ul_value']) ." (" .date('H:i', strtotime($data['SiteMaximsDailyValue']['ml_datetime'])).")",
                );
		}


		$this->set('title_for_layout', "Trafico para ".$siteName);
		$this->set(compact('metricsUl', 'metricsDl', 'site'));		
	}


}
