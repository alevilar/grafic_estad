<?php
App::uses('SkpiAppController', 'Skpi.Controller');


class DateKpisController extends SkpiAppController {
	

	public $helpers = array(
		
		'Sky.Kpi'
	);


	public $components = array(
		'RequestHandler',
        'Search.Prg' => array(
            'presetForm' => array(
                'paramType' => 'querystring',
            ),
            'commonProcess' => array(
                'paramType' => 'querystring',
                'filterEmpty' => true,
            ),
        ),
    );




    /**
     * Preset Variable Search
     *
     * @var array
     * @access public
     */
    public $presetVars = true;
       


	public function beforeRender () {
		$this->set( 'kpiFields', $this->DateKpi->kpiFields );
		return parent::beforeRender();
	
	}


	public function graf_max_uldl_de_sitio ( $sitio_id ) {
		$this->Prg->commonProcess();
        $conditions = $this->DateKpi->parseCriteria($this->request->query);

        if ( !empty($conditions['Site.id'])) {
				$sitio_id = $conditions['Site.id'];
		}

        if ( empty( $conditions['DateKpi.date <='] )) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
		}

		if ( empty( $conditions['DateKpi.date >='] )) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		}


		$conditions['Site.id'] = $sitio_id;
		$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
	

		if ( !empty($dateFrom) ) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime( $dateFrom ));
		}

		if ( !empty($dateTo) ) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime( $dateTo ));
		}

		$kpis = $this->DateKpi->find( 'all', array(
			'conditions' => $conditions,			
			'order' => array(
				'DateKpi.date'
				),
			)
		);

		if (!empty( $conditions['DateKpi.date <='] )) {
			$this->request->data['DateKpi']['date_to'] = $conditions['DateKpi.date <='];	
		}

		if (!empty( $conditions['DateKpi.date >='] )) {
			$this->request->data['DateKpi']['date_from'] = $conditions['DateKpi.date >='];
		}
	
		$this->DateKpi->Carrier->Sector->Site->contain( array('Sector.Carrier') );
		$site = $this->DateKpi->Carrier->Sector->Site->read(null , $sitio_id);
		$this->set('title_for_layout', $site['Site']['name']);

		$this->set('sites', $this->DateKpi->Carrier->Sector->Site->find('list') );


		$newKpisBySite = array();
		foreach ( $kpis as $k ) {			
			$site_id = $k['Carrier']['Sector']['site_id'];
			$newKpisBySite[$site_id][] = $k;
		}
		$mosNewKpiDl = array();
		$mosNewKpiUl = array();
		foreach ($newKpisBySite as $site=>$nk) {
			foreach ($nk as $byDay) {				
				$mosNewKpiDl[] = array(
					$byDay['DateKpi']['date'],
					$byDay['DateKpi']['max_dl'],
					);
				$mosNewKpiUl[] = array(
					$byDay['DateKpi']['date'],
					$byDay['DateKpi']['max_ul'],
					);	
			}			
		}		
		
		$this->set('sitio', $site );
		$this->request->data['DateKpi']['site_id'] = $sitio_id;
		$this->set('kpis', array(array_values($mosNewKpiDl), array_values($mosNewKpiUl)));
	//	$this->set('_serialize', array('kpis', 'sitio', 'title_for_layout'));
	}


	public function max_uldl_x_sitio () {
		$this->Prg->commonProcess();
        $conditions = $this->DateKpi->parseCriteria($this->request->query);


		if ( empty( $conditions['DateKpi.date <='] )) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
		}

		if ( empty( $conditions['DateKpi.date >='] )) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-2 day'));
		}


		$kpis = $this->DateKpi->find( 'all', array(
			'conditions' => $conditions,			
			'order' => array(
				'DateKpi.date',
				'Site.name',
				),
			)
		);
	
		if (!empty( $conditions['DateKpi.date <='] )) {
			$this->request->data['DateKpi']['date_to'] = $conditions['DateKpi.date <='];	
		}

		if (!empty( $conditions['DateKpi.date >='] )) {
			$this->request->data['DateKpi']['date_from'] = $conditions['DateKpi.date >='];
		}

		$this->set('sites_list', $this->DateKpi->Carrier->Sector->Site->find('list') );
		$this->set('title_for_layout', "Máximo DL/UL por Sitio");				
		$this->set('kpis', $kpis );
	}





	/**
	*  KPI por sitio
	**/
	public function by_site ( $sitio_id = null , $dateFrom = null, $dateTo = null) {	
		$this->Prg->commonProcess();
        $conditions = $this->DateKpi->parseCriteria($this->request->query);

        if ( !empty($conditions['Site.id'])) {
				$sitio_id = $conditions['Site.id'];
		}

        if ( empty( $conditions['DateKpi.date <='] )) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
		}

		if ( empty( $conditions['DateKpi.date >='] )) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		}


		$conditions['Site.id'] = $sitio_id;
		$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
	

		if ( !empty($dateFrom) ) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime( $dateFrom ));
		}

		if ( !empty($dateTo) ) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime( $dateTo ));
		}

		$kpis = $this->DateKpi->find( 'all', array(
			'conditions' => $conditions,			
			'order' => array(
				'DateKpi.date'
				),
			)
		);

		if (!empty( $conditions['DateKpi.date <='] )) {
			$this->request->data['DateKpi']['date_to'] = $conditions['DateKpi.date <='];	
		}

		if (!empty( $conditions['DateKpi.date >='] )) {
			$this->request->data['DateKpi']['date_from'] = $conditions['DateKpi.date >='];
		}
	
		$this->DateKpi->Carrier->Sector->Site->contain( array('Sector.Carrier') );
		$site = $this->DateKpi->Carrier->Sector->Site->read(null , $sitio_id);
		$this->set('title_for_layout', "Sitio: ". $site['Site']['name']);

		$this->set('sites', $this->DateKpi->Carrier->Sector->Site->find('list') );

		
		$this->set('sitio', $site );
		$this->request->data['DateKpi']['site_id'] = $sitio_id;
		$this->set('kpis', $kpis );
	}





	/**
	*  KPI por sector
	**/
	public function by_sector ( $sector_id = null, $dateFrom = null, $dateTo = null) {		
		if ( empty($sector_id) ) {
			throw new Exception("Se debe especificar un sector");		
		}

		$this->Prg->commonProcess();
        $conditions = $this->DateKpi->parseCriteria($this->request->query);


        if ( empty( $conditions['DateKpi.date <='] )) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
		}

		if ( empty( $conditions['DateKpi.date >='] )) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		}


		$conditions['Sector.id'] = $sector_id;
		$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
	

		if ( !empty($dateFrom) ) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime( $dateFrom ));
		}

		if ( !empty($dateTo) ) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime( $dateTo ));
		}

		$kpis = $this->DateKpi->find( 'all', array(
			'conditions' => $conditions,
			'order' => array(
				'DateKpi.date'
				),
			)
		);
	
		$this->set('sites', $this->DateKpi->Carrier->Sector->Site->find('list') );
		$this->DateKpi->Carrier->Sector->Site->contain( array('Sector.Carrier') );	

		if (!empty( $conditions['DateKpi.date <='] )) {
			$this->request->data['DateKpi']['date_to'] = $conditions['DateKpi.date <='];	
		}

		if (!empty( $conditions['DateKpi.date >='] )) {
			$this->request->data['DateKpi']['date_from'] = $conditions['DateKpi.date >='];
		}


		$site = $this->DateKpi->Carrier->Sector->getSite($sector_id);
		$this->set('sitio', $this->DateKpi->Carrier->Sector->Site->read(null , $site['id']) );
		$this->request->data['DateKpi']['site_id'] = $site['id'];
		$this->set('kpis', $kpis );
		$sector = $this->DateKpi->Carrier->Sector->read(null, $sector_id);
		$this->set('title_for_layout', "Sitio: ". $site['name'] . " Sector: ".$sector['Sector']['name']);
		$this->render('by_site');
	}

	


	/**
	*  KPI por carrier
	**/
	public function by_carrier ( $carrier_id , $dateFrom = null, $dateTo = null) {		
		if ( empty($carrier_id) ) {
			throw new Exception("Se debe especificar un ID de carrier");		
		}

		$this->Prg->commonProcess();
        $conditions = $this->DateKpi->parseCriteria($this->request->query);


        if ( empty( $conditions['DateKpi.date <='] )) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
		}

		if ( empty( $conditions['DateKpi.date >='] )) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		}


		$conditions['Carrier.id'] = $carrier_id;
		$conditions['DateKpi.date >='] = date('Y-m-d', strtotime('-1 week'));
		$conditions['DateKpi.date <='] = date('Y-m-d', strtotime('now'));
	

		if ( !empty($dateFrom) ) {
			$conditions['DateKpi.date >='] = date('Y-m-d', strtotime( $dateFrom ));
		}

		if ( !empty($dateTo) ) {
			$conditions['DateKpi.date <='] = date('Y-m-d', strtotime( $dateTo ));
		}

		$kpis = $this->DateKpi->find( 'all', array(
			'conditions' => $conditions,
			'order' => array(
				'DateKpi.date'
				),
			)
		);


		if (!empty( $conditions['DateKpi.date <='] )) {
			$this->request->data['DateKpi']['date_to'] = $conditions['DateKpi.date <='];	
		}

		if (!empty( $conditions['DateKpi.date >='] )) {
			$this->request->data['DateKpi']['date_from'] = $conditions['DateKpi.date >='];
		}

	
		$this->set('sites', $this->DateKpi->Carrier->Sector->Site->find('list') );
		$this->DateKpi->Carrier->Sector->Site->contain( array('Sector.Carrier') );
		$site = $this->DateKpi->Carrier->getSite($carrier_id);
		$this->set('sitio', $this->DateKpi->Carrier->Sector->Site->read(null , $site['id']) );
		$this->request->data['DateKpi']['site_id'] = $site['id'];
		$this->set('kpis', $kpis );
		$carrier = $this->DateKpi->Carrier->read(null, $carrier_id);
		$this->set('title_for_layout', "Sitio: ". $site['name'] . "<br>Sector: ".$carrier['Sector']['name']. "<br>Carrier: ".$carrier['Carrier']['name']);		
		$this->render('by_site');
	}
	
}
	