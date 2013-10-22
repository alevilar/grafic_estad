<?php
App::uses('SkyAppController', 'Sky.Controller');
/**
 * SkyCarriers Controller
 * 
 * 
 *
 */
class LogMstationsController extends SkyAppController {

    /**
    * Components
    *
    * @var array
    * @access public
    */
    public $components = array(
//            'RequestHandler',
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
     *
     * @var PrgComponent
     */
    public $Prg;
       
    /**
     * Preset Variable Search
     *
     * @var array
     * @access public
     */
	public $presetVars = true;
        
        
        public function beforeFilter()
        {
            $this->Prg->commonProcess();
            $this->paginate = array(
                'conditions' => $this->LogMstation->parseCriteria( $this->request->query ),
                'recursive' => -1,                
                'limit' => 20,
                'order' => array(
                    'MsLogTable.datetime' => 'desc',
                    'MsLogTable.site_id' => 'desc',
                ),
            );
            
            
             // si viene del formulario
            // seteo el numero de pagina a la primer pagina (viene en un hidden)
            if ( isset($this->request->query['page']) ) {
                 $this->request->params['named']['page'] = $this->request->query['page'];
                 unset($this->request->query['page']);
             }
             
             if ( empty($this->paginate['conditions']['MsLogTable.datetime'])
                  && 
                empty($this->paginate['conditions']['MsLogTable.datetime >='])
                && empty($this->paginate['conditions']['MsLogTable.datetime <='])
                ) {
                $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
                $this->paginate['conditions']['MsLogTable.datetime'] = $lastDatetime['Migration']['id'];
                $this->request->data['LogMstation']['datetime'] = $lastDatetime['Migration']['id'];
            }
            
            return parent::beforeFilter();
        }
        

	public function index() {    
            $this->paginate['joindata'] = true;
            if ( !empty($this->request->params['ext']) && $this->request->params['ext'] == 'xls') {    
                $maxReg = Configure::read('Sky.max_reg_export');
                if ( $maxReg ) {
                    $this->paginate['limit'] = $maxReg;
                } else {
                    unset( $this->paginate['limit'] );
                }
                unset($this->paginate['offset']);
                $log_mstations = $this->LogMstation->find('all', $this->paginate);
            } else {       
                $log_mstations = $this->paginate();
            }
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC'));
            $mimos = $this->LogMstation->Mimo->find('list');
            $fecs = $this->LogMstation->UlFec->find('list', array( 'fields' => array('id', 'full_name')));
            $this->set(compact('datetimes','sites', 'mimos', 'fecs', 'log_mstations'));
        }
        
        
        public function modulaciones() {
            $this->paginate['joindata'] = true;
            $this->paginate['limit'] = Configure::read('Sky.max_reg_export');
            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
//            $this->paginate['recursive'] = 1;
            $this->paginate['order'] = 'DlFec.id';
            $this->paginate['fields'] = array('DlFec.modulation', 'DlFec.id', 'DlFec.line_color', 'count(1) as cant');
            $this->paginate['group'] = array(
                'DlFec.modulation',
            );
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'10'));
            $this->set(compact('datetimes','sites', 'mimos', 'log_mstations'));            
        }
        
        
        public function modulaciones_x_sitio() {
            $this->paginate['joindata'] = true;
            $this->paginate['limit'] = Configure::read('Sky.max_reg_export');
            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
//            $this->paginate['recursive'] = 1;
            $this->paginate['order'] = array('Site.name', 'DlFec.id');
            $this->paginate['fields'] = array(
                'MsLogTable.site_id',
                'Site.name',
                'DlFec.modulation', 
                'DlFec.id', 
                'DlFec.line_color', 
                'count(1) as cant'
                );
            $this->paginate['group'] = array(
                'MsLogTable.site_id',
                'DlFec.modulation',
            );
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $results = array();
            $colors = array();
            foreach ( $log_mstations as $lms ) {
                $results[$lms['MsLogTable']['site_id']]['Site'] = $lms['Site'];
                if ( !array_key_exists('DlFec', $results[$lms['MsLogTable']['site_id']])
                        || !is_array($results[$lms['MsLogTable']['site_id']]['DlFec'])) {
                    $results[$lms['MsLogTable']['site_id']]['DlFec'] = array();
                }
                $lms['DlFec']['cant'] = $lms[0]['cant'];                
                $results[$lms['MsLogTable']['site_id']]['DlFec'][] = $lms['DlFec'];
            }
            $log_mstations = $results;
//            debug($log_mstations); die;
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $dl_fecs = $this->LogMstation->DlFec->find('list', array('fields'=>array( 'DlFec.modulation', 'DlFec.line_color')));
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'10'));
            $this->set(compact('datetimes','sites', 'mimos', 'log_mstations', 'dl_fecs'));            
        }
        
        
        public function graf_mimo() {
            $this->paginate['joindata'] = true;
            $this->paginate['limit'] = Configure::read('Sky.max_reg_export');
            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
//            $this->paginate['recursive'] = 1;
            $this->paginate['order'] = 'DlFec.id';
            $this->paginate['fields'] = array(
                'LogMstation.mimo_id',                
                'DlFec.modulation', 
                'DlFec.id', 
                'DlFec.line_color', 
                'Mimo.line_color',
                'count(1) as cant'
            );
            $this->paginate['group'] = array(
                'LogMstation.mimo_id',
                'DlFec.modulation',
            );
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'10'));
            $this->set(compact('datetimes','sites', 'mimos', 'log_mstations'));
        }

}
