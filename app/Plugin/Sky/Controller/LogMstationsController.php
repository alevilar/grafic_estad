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
            $conds = $this->LogMstation->parseCriteria( $this->request->query );
            $this->paginate = array(
                'conditions' => $conds,
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
             
             
             // Hago que se filtre por defecto en el datetime ultimo (ultima migracion)
             if ( !in_array($this->action, array('max_usuarios_x_modulacion', 'usuarios_x_modulacion')) ) {
                if ( empty($this->paginate['conditions']['MsLogTable.datetime'])
                     && 
                   empty($this->paginate['conditions']['MsLogTable.datetime >='])
                   && empty($this->paginate['conditions']['MsLogTable.datetime <='])
                   ) {
                   $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
                   $this->paginate['conditions']['MsLogTable.datetime'] = $lastDatetime['Migration']['id'];
                   $this->request->data['LogMstation']['datetime'] = $lastDatetime['Migration']['id'];
               }
             }
             
             if (!empty($this->paginate['conditions']['MsLogTable.datetime >=']) ||
                     !empty($this->paginate['conditions']['MsLogTable.datetime <='])) {
                  unset($this->paginate['conditions']['MsLogTable.datetime']);
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
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'100'));
            $mimos = $this->LogMstation->Mimo->find('list');
            $fecs = $this->LogMstation->UlFec->find('list', array( 'fields' => array('id', 'full_name')));
            $this->set(compact('datetimes','sites', 'mimos', 'fecs', 'log_mstations'));
        }
        
        
        public function modulaciones() {
            $this->paginate['limit'] = null;
            $this->paginate['joindata'] = true;
            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
            $this->paginate['recursive'] = -1;
            $this->paginate['order'] = 'DlFec.id';
            $this->paginate['fields'] = array('DlFec.modulation', 'DlFec.id', 'DlFec.line_color', 'count(1) as cant');
            $this->paginate['group'] = array(
                'DlFec.modulation',
            );
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'100'));
            $this->set(compact('datetimes','sites', 'mimos', 'log_mstations'));            
        }
        
        
        public function modulaciones_x_sitio() {
            $this->paginate['joindata'] = true;
            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
//            $this->paginate['recursive'] = 1;
            $this->paginate['limit'] = null;
            $this->paginate['order'] = array('Site.name', 'DlFec.id');
            $this->paginate['fields'] = array(
                'Site.id',
                'Site.name',
                'DlFec.modulation', 
                'DlFec.id', 
                'DlFec.line_color', 
                'count(1) as cant'
                );
            $this->paginate['group'] = array(
                'Site.id',
                'DlFec.id',
                'DlFec.modulation',
            );
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $results = array();
            foreach ( $log_mstations as $lms ) {
                    $results[$lms['Site']['id']]['Site'] = $lms['Site'];
                if ( !array_key_exists('DlFec', $results[$lms['Site']['id']])
                        || !is_array($results[$lms['Site']['id']]['DlFec'])) {
                    $results[$lms['Site']['id']]['DlFec'] = array();
                }
                $lms['DlFec']['cant'] = $lms[0]['cant'];                
                $results[$lms['Site']['id']]['DlFec'][] = $lms['DlFec'];
            }
            $log_mstations = $results;
            
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $dl_fecs = $this->LogMstation->DlFec->find('list', array('fields'=>array( 'DlFec.modulation', 'DlFec.line_color')));
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'100'));
            $this->set(compact('datetimes','sites', 'mimos', 'log_mstations', 'dl_fecs'));            
        }
        
        
        public function graf_mimo() {
            $this->paginate['limit'] = null;
            $this->paginate['joindata'] = true;
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
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'100'));
            $this->set(compact('datetimes','sites', 'mimos', 'log_mstations'));
            if ($this->request->is('ajax')){
                $this->render("ajax_graf_mimo");
            }
        }
        
        
        
        public function usuarios_x_modulacion() {
            
            if ( empty($this->paginate['conditions']['MsLogTable.datetime'])
                  && 
                empty($this->paginate['conditions']['MsLogTable.datetime >='])
                && empty($this->paginate['conditions']['MsLogTable.datetime <='])
                ) {
                $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
                $nuevafecha = strtotime( '-2 day' , strtotime( $lastDatetime['Migration']['id'] ) ) ;
                $this->paginate['conditions']['MsLogTable.datetime BETWEEN ? and ?'] = array(
                    date('Y-m-d H:i:s', $nuevafecha),
                    $lastDatetime['Migration']['id']
                    );
                unset( $this->paginate['conditions']['MsLogTable.datetime'] );
            }
            
            
            $this->paginate['joindata'] = true;
            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
//            $this->paginate['recursive'] = 1;
            $this->paginate['order'] = array(
                'DlModulation.modulation_type_id',  
                'MsLogTable.datetime ASC',
            );
            $this->paginate['fields'] = array(
                'MsLogTable.datetime',
                'DlModulation.modulation_type_id',
                'count(1) as cant',
            );
            $this->paginate['group'] = array(
                'DlModulation.modulation_type_id',  
                'MsLogTable.datetime',
                              
            );
            
            $this->paginate['limit'] = null;
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $nlog = array(
                '64QAM' => array(),
                '16QAM' => array(),
                'QPSK' => array()
            );
            foreach ( $log_mstations as $lm ) {
                $nlog[$lm['DlModulation']['modulation_type_id']][] = array(
                    $lm['MsLogTable']['datetime'],
                    $lm[0]['cant']
                );
            }
            $log_mstations = $nlog;
            unset($log_mstations["Series 1"]);
            
            // colocar los colores de cada linea
            $mdtypes = ClassRegistry::init('Sky.ModulationType')->find('list', array('fields'=>array('id', 'line_color')));
            $dataColor = array();
            foreach($log_mstations as $lllmmm=>$llldata) {
                $dataColor[] = $mdtypes[$lllmmm];
            }
            
    //        $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
//            $mimos = $this->LogMstation->Mimo->find('list');
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'100'));
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $this->set(compact('datetimes', 'log_mstations', 'sites', 'mimos', 'dataColor'));
        }
        
        
        public function max_usuarios_x_modulacion () {
            
            if ( empty($this->paginate['conditions']['MsLogTable.datetime'])
                  && 
                empty($this->paginate['conditions']['MsLogTable.datetime >='])
                && empty($this->paginate['conditions']['MsLogTable.datetime <='])
                ) {
                $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
                $nuevafecha = strtotime( '-7 day' , strtotime( $lastDatetime['Migration']['id'] ) ) ;
                $fechaDesde = date('Y-m-d H:i:s', $nuevafecha);
                $fechaHasta = $lastDatetime['Migration']['id'];
                $this->paginate['conditions']['MsLogTable.datetime BETWEEN ? and ?'] = array(
                    $fechaDesde,
                    $fechaHasta
                    );
                unset( $this->paginate['conditions']['MsLogTable.datetime'] );
            }
            
            
            if (!empty($this->paginate['conditions']['MsLogTable.datetime >='])) {
                $fechaDesde = $this->paginate['conditions']['MsLogTable.datetime >='];
            }
            
            if (!empty($this->paginate['conditions']['MsLogTable.datetime <='])) {
                $fechaHasta = $this->paginate['conditions']['MsLogTable.datetime <='];
            }
//            $this->paginate['conditions'][] = 'DlFec.modulation IS NOT NULL';
            
            $this->paginate['limit'] = null;
            
            // detectar maximos, primeo buscar todos
            $all = $this->LogMstation->find('all', array(
                'fields' => array(
                    'count(1) as cant', 
                    'DATE(MsLogTable.datetime) as date',
                    'MsLogTable.datetime'
                ),
                'conditions' => $this->paginate['conditions'],
                'joindata' => true,
                'group' => 'MsLogTable.datetime',
                
            ));
            // filtrar los maximos
            $results = array();
            
            foreach ($all as $aa) {
                $auxKey = $aa[0]['date'];
                $auxCant = (int)$aa[0]['cant'];
                if ( array_key_exists($auxKey, $results) ) {
                    if ( $results[$auxKey]['cant'] < $auxCant) {
                        $results[$auxKey] = array(
                            'cant' => $auxCant,
                            'datetime' =>  $aa['MsLogTable']['datetime'],
                        );
                    }
                } else {
                    $results[$auxKey] = array(
                        'cant' => $auxCant,
                        'datetime' => $aa['MsLogTable']['datetime']
                    );
                }
            }
            $resutsDatetime = array();
            foreach($results as $r) {
                $resutsDatetime[] = $r['datetime'];
            }
            
            $this->paginate['joindata'] = true;
             
            $this->paginate['conditions'][] = array('MsLogTable.datetime' => $resutsDatetime);
            
//            $this->paginate['recursive'] = 1;
            $this->paginate['order'] = array(
                'DlModulation.modulation_type_id',
                'MsLogTable.datetime',
            );
            $this->paginate['fields'] = array(
                'MsLogTable.datetime',
                'DlModulation.modulation_type_id',
                'count(1) as cant',
            );
            $this->paginate['group'] = array(
                'DlModulation.modulation_type_id',  
                'MsLogTable.datetime',
            );
            
            
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
            $mdtypes = ClassRegistry::init('Sky.ModulationType')->find('list', array(
                'fields'=> array('id', 'line_color'), 
                'order' => 'ModulationType.order'
                ));
            $nlog = $mdtypes;
            foreach ($nlog as &$nnnnl) {
                $nnnnl = array();
            }
            foreach ( $log_mstations as $lm ) {
                if (array_key_exists($lm['DlModulation']['modulation_type_id'], $nlog)) {
                    $nlog[$lm['DlModulation']['modulation_type_id']][] = array(
                        date('Y-m-d', strtotime($lm['MsLogTable']['datetime'])),
                        $lm[0]['cant']
                    );
                }
            }
            $log_mstations = $nlog;
            
            //hack para esto que aparece y no quiero que se muestre
            unset($log_mstations["Series 1"]);
            
            // colocar los colores de cada linea
            $dataColor = array();
            foreach($log_mstations as $lllmmm=>$llldata) {
                $dataColor[] = $mdtypes[$lllmmm];
            }
            
            $labels = array();
            $cantTot = count($log_mstations['16QAM']);
            $i = -1;
            while ($i++ < $cantTot-1) {
                $sumaTot = $log_mstations['16QAM'][$i][1] + $log_mstations['64QAM'][$i][1] + $log_mstations['QPSK'][$i][1];
                $labels64[$i] = round($log_mstations['64QAM'][$i][1]/$sumaTot*10000)/100 . '%';
                $labels16[$i] = round($log_mstations['16QAM'][$i][1]/$sumaTot*10000)/100 . '%';
                $labelsqpsk[$i] = round($log_mstations['QPSK'][$i][1]/$sumaTot*10000)/100 . '%';
            }
//            $mimos = $this->LogMstation->Mimo->find('list');
            $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit'=>'100'));
            $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
            $mimos = $this->LogMstation->Mimo->find('list');
            $this->set(compact('labels64','labels16', 'labelsqpsk', 'datetimes','log_mstations', 'sites', 'mimos', 'dataColor', 'fechaDesde', 'fechaHasta'));
        }
}
