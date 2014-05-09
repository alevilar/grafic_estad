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
        

        $sitiosDl = $this->KpiDataDay->getSumValueForSite( SK_KPI_MAX_DL_ID, $days, $sitio_id);
        $sitiosUl = $this->KpiDataDay->getSumValueForSite( SK_KPI_MAX_UL_ID, $days, $sitio_id);
        

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

    public function max_uldl_x_sitio( $ul_or_dl_id = SK_KPI_MAX_DL_ID )
    {
        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);


        if (empty($conditions['KpiDataDay.ml_date <='])) {
            $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.ml_date >='])) {
            $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime('-10 day'));
        }
        
        
        $days = $this->KpiDataDay->find('list', array(
                'conditions' => $conditions,
                'group' => 'KpiDataDay.ml_date',
                'fields' => array('ml_date', 'ml_date')
        ));
        

        $sitios = $this->KpiDataDay->getSumValueForSite( $ul_or_dl_id, $days);

        if (!empty($conditions['KpiDataDay.ml_date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.ml_date <='];
        }

        if (!empty($conditions['KpiDataDay.ml_date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.ml_date >='];
        }

        $kpi = $this->KpiDataDay->KpiDailyValue->Kpi->read(null, $ul_or_dl_id);
        $this->set('kpi', $kpi);
        $this->set('days', array_values($days));
        $this->set('sites_list', $this->KpiDataDay->Carrier->Sector->Site->find('list'));
        $this->set('title_for_layout', $kpi['Kpi']['name']." por Sitio");
        $this->set('kpis', $sitios);
    }

    /**
     *  KPI por sitio
     * */
    public function by_kpi($fieldName, $dateFrom = null, $dateTo = null)
    {


        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);


        if (empty($conditions['KpiDataDay.date <='])) {
            $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.date >='])) {
            $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime('-1 week'));
        }



        if (empty($fieldName)) {
            throw new Exception("Se debe especificar un nombre de KPI");
        }
        if (!array_key_exists($fieldName, $this->KpiDataDay->kpiFields)) {
            throw new Exception("El KPI pasado como prámetro no es válido");
        }




        if (!empty($dateFrom)) {
            $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime($dateFrom));
        }

        if (!empty($dateTo)) {
            $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime($dateTo));
        }

        $kpis = $this->KpiDataDay->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'KpiDataDay.date',
                'Site.name',
            ),
                )
        );

        if (!empty($conditions['KpiDataDay.date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.date <='];
        }

        if (!empty($conditions['KpiDataDay.date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.date >='];
        }

        $this->set('sites_list', $this->KpiDataDay->Carrier->Sector->Site->find('list'));
        $this->set('title_for_layout', "Kpi: " . $this->KpiDataDay->kpiFields[$fieldName]);
        $this->set('fieldName', $fieldName);
        $this->set('kpis', $kpis);
    }

    /**
     *  KPI por sitio
     * */
    public function by_site($sitio_id = null, $dateFrom = null, $dateTo = null)
    {
        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);

        if (!empty($conditions['Site.id'])) {
            $sitio_id = $conditions['Site.id'];
        }

        if (empty($conditions['KpiDataDay.ml_date <='])) {
            $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.date >='])) {
            $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        }

        $conditions['KpiDataDay.carrier_id IN'] = $this->KpiDataDay->Carrier->Sector->Site->listCarriers($sitio_id);;
        $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime('-1 week'));
        $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime('now'));


        if (!empty($dateFrom)) {
            $conditions['KpiDataDay.ml_date >='] = date('Y-m-d', strtotime($dateFrom));
        }

        if (!empty($dateTo)) {
            $conditions['KpiDataDay.ml_date <='] = date('Y-m-d', strtotime($dateTo));
        }
        
        $days = $this->KpiDataDay->find('list', array(
                'conditions' => $conditions,
                'group' => 'KpiDataDay.ml_date',
                'fields' => array('ml_date', 'ml_date')
        ));

        
        $kpis = $this->KpiDataDay->KpiDailyValue->Kpi->find('all', array('recursive'=>-1));
        foreach($kpis as &$k) {
            $k['Day'] = array();
            foreach($days as $day) {
                 $siteData = $this->KpiDataDay->getSumValueForSite( $k['Kpi']['id'], $day, $sitio_id );
                 
                 // index CERO porque siempre va a ser 1 dia que estoy recorriendo
                 $k['Day'][] = $siteData['Day'][0];
            }
        }
                
        if (!empty($conditions['KpiDataDay.ml_date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.ml_date <='];
        }

        if (!empty($conditions['KpiDataDay.ml_date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.ml_date >='];
        }

        $this->KpiDataDay->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->KpiDataDay->Carrier->Sector->Site->read(null, $sitio_id);
        $this->set('title_for_layout', "Sitio: " . $site['Site']['name']);

        $this->set('sites', $this->KpiDataDay->Carrier->Sector->Site->find('list'));

        $this->set('days', $days);
        $this->set('sitio', $site);
        $this->request->data['KpiDataDay']['site_id'] = $sitio_id;
        $this->set('kpis', $kpis);
    }

    /**
     *  KPI por sector
     * */
    public function by_sector($sector_id = null, $dateFrom = null, $dateTo = null)
    {
        if (empty($sector_id)) {
            throw new Exception("Se debe especificar un sector");
        }

        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);


        if (empty($conditions['KpiDataDay.date <='])) {
            $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.date >='])) {
            $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime('-1 week'));
        }


        $conditions['Sector.id'] = $sector_id;
        $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime('-1 week'));
        $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime('now'));


        if (!empty($dateFrom)) {
            $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime($dateFrom));
        }

        if (!empty($dateTo)) {
            $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime($dateTo));
        }

        $kpis = $this->KpiDataDay->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'KpiDataDay.date'
            ),
                )
        );

        $this->set('sites', $this->KpiDataDay->Carrier->Sector->Site->find('list'));
        $this->KpiDataDay->Carrier->Sector->Site->contain(array('Sector.Carrier'));

        if (!empty($conditions['KpiDataDay.date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.date <='];
        }

        if (!empty($conditions['KpiDataDay.date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.date >='];
        }


        $site = $this->KpiDataDay->Carrier->Sector->getSite($sector_id);
        $this->set('sitio', $this->KpiDataDay->Carrier->Sector->Site->read(null, $site['id']));
        $this->request->data['KpiDataDay']['site_id'] = $site['id'];
        $this->set('kpis', $kpis);
        $sector = $this->KpiDataDay->Carrier->Sector->read(null, $sector_id);
        $this->set('title_for_layout', "Sitio: " . $site['name'] . " Sector: " . $sector['Sector']['name']);
        $this->render('by_site');
    }

    /**
     *  KPI por carrier
     * */
    public function by_carrier($carrier_id, $dateFrom = null, $dateTo = null)
    {
        if (empty($carrier_id)) {
            throw new Exception("Se debe especificar un ID de carrier");
        }

        $this->Prg->commonProcess();
        $conditions = $this->KpiDataDay->parseCriteria($this->request->query);


        if (empty($conditions['KpiDataDay.date <='])) {
            $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['KpiDataDay.date >='])) {
            $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime('-1 week'));
        }


        $conditions['Carrier.id'] = $carrier_id;
        $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime('-1 week'));
        $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime('now'));


        if (!empty($dateFrom)) {
            $conditions['KpiDataDay.date >='] = date('Y-m-d', strtotime($dateFrom));
        }

        if (!empty($dateTo)) {
            $conditions['KpiDataDay.date <='] = date('Y-m-d', strtotime($dateTo));
        }

        $kpis = $this->KpiDataDay->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'KpiDataDay.date'
            ),
                )
        );


        if (!empty($conditions['KpiDataDay.date <='])) {
            $this->request->data['KpiDataDay']['date_to'] = $conditions['KpiDataDay.date <='];
        }

        if (!empty($conditions['KpiDataDay.date >='])) {
            $this->request->data['KpiDataDay']['date_from'] = $conditions['KpiDataDay.date >='];
        }


        $this->set('sites', $this->KpiDataDay->Carrier->Sector->Site->find('list'));
        $this->KpiDataDay->Carrier->Sector->Site->contain(array('Sector.Carrier'));
        $site = $this->KpiDataDay->Carrier->getSite($carrier_id);
        $this->set('sitio', $this->KpiDataDay->Carrier->Sector->Site->read(null, $site['id']));
        $this->request->data['KpiDataDay']['site_id'] = $site['id'];
        $this->set('kpis', $kpis);
        $carrier = $this->KpiDataDay->Carrier->read(null, $carrier_id);
        $this->set('title_for_layout', "Sitio: " . $site['name'] . "<br>Sector: " . $carrier['Sector']['name'] . "<br>Carrier: " . $carrier['Carrier']['name']);
        $this->render('by_site');
    }

}

