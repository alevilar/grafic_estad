<?php

App::uses('SkpiAppController', 'Skpi.Controller');

class KpisController extends SkpiAppController
{

    public $helpers = array(
        'Sky.Kpi'
    );
    
    public $components = array(
		'Croogo.Croogo',
		'Security',
		'Acl',
		'Auth',
		'Session',
		'RequestHandler',
                'DebugKit.Toolbar',
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

    public function beforeRender()
    {
        die("asas");
        $this->set('kpiFields', $this->DailyKpiValue->Kpi->find('list'));
        return parent::beforeRender();
    }

    
    
    /**
     *  KPI por sitio
     * */
    public function view_daily_kpi( $id, $dateFrom = null, $dateTo = null)
    {

        

        //$this->Prg->commonProcess();
        //$conditions = $this->Kpi->DailyKpiValue->parseCriteria($this->request->query);


        if (empty($conditions['DailyKpiValue.date <='])) {
            $conditions['DailyKpiValue.date <='] = date('Y-m-d', strtotime('now'));
        }

        if (empty($conditions['DailyKpiValue.date >='])) {
            $conditions['DailyKpiValue.date >='] = date('Y-m-d', strtotime('-1 week'));
        }



        if (empty($fieldName)) {
            throw new Exception("Se debe especificar un nombre de KPI");
        }
        if (!array_key_exists($fieldName, $this->Kpi->DailyKpiValue->kpiFields)) {
            throw new Exception("El KPI pasado como prámetro no es válido");
        }




        if (!empty($dateFrom)) {
            $conditions['DailyKpiValue.date >='] = date('Y-m-d', strtotime($dateFrom));
        }

        if (!empty($dateTo)) {
            $conditions['DailyKpiValue.date <='] = date('Y-m-d', strtotime($dateTo));
        }

        $kpis = $this->DailyKpiValue->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'DailyKpiValue.date',
                'Site.name',
            ),
                )
        );

        if (!empty($conditions['DailyKpiValue.date <='])) {
            $this->request->data['DailyKpiValue']['date_to'] = $conditions['DailyKpiValue.date <='];
        }

        if (!empty($conditions['DailyKpiValue.date >='])) {
            $this->request->data['DailyKpiValue']['date_from'] = $conditions['DailyKpiValue.date >='];
        }

        $kpi = $this->Kpi->read(null, $id);
        
        
        $this->set('sites_list', $this->DailyKpiValue->Carrier->Sector->Site->find('list'));
        $this->set('title_for_layout', "Kpi: " . $this->DailyKpiValue->kpiFields[$fieldName]);
        $this->set('fieldName', $fieldName);
        $this->set('kpis', $kpis);
        
        $this->set(compact('kpi'));
    }

}

