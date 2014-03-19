<?php

App::uses('SkyAppController', 'Sky.Controller');

/**
 * SkyCarriers Controller
 * 
 * 
 *
 */
class LogMstationsController extends SkyAppController
{

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
        if ($this->action != 'delete' ) {
            $this->Prg->commonProcess();
            $conds = $this->LogMstation->parseCriteria($this->request->query);
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
            if (isset($this->request->query['page'])) {
                $this->request->params['named']['page'] = $this->request->query['page'];
                unset($this->request->query['page']);
            }


            // Hago que se filtre por defecto en el datetime ultimo (ultima migracion)
            if (!in_array($this->action, array('max_usuarios_x_modulacion', 'usuarios_x_modulacion'))) {
                if (empty($this->paginate['conditions']['MsLogTable.datetime']) &&
                        empty($this->paginate['conditions']['MsLogTable.datetime >=']) && empty($this->paginate['conditions']['MsLogTable.datetime <='])
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


        }
        return parent::beforeFilter();
    }

    public function index()
    {
        $this->paginate['joindata'] = true;
        if (!empty($this->request->params['ext']) && $this->request->params['ext'] == 'xls') {
            $maxReg = Configure::read('Sky.max_reg_export');
            if ($maxReg) {
                $this->paginate['limit'] = $maxReg;
            } else {
                unset($this->paginate['limit']);
            }
            unset($this->paginate['offset']);
            $log_mstations = $this->LogMstation->find('all', $this->paginate);
        } else {
            $log_mstations = $this->paginate();
        }
        $sites = $this->LogMstation->MsLogTable->Site->find('list');
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $mimos = $this->LogMstation->Mimo->find('list');
        $fecs = $this->LogMstation->UlFec->find('list', array('fields' => array('id', 'full_name')));
        $this->set(compact('datetimes', 'sites', 'mimos', 'fecs', 'log_mstations'));
    }
    
    public function delete ($id = null) {
        if (!$id) {
                $this->Session->setFlash(__d('sky', 'Invalid id for MStation'), 'default', array('class' => 'alert alert-danger error'));
                $this->redirect(array('action' => 'index'));
        }
        if ($this->LogMstation->delete($id)) {
            $this->Session->setFlash(__d('sky', 'MStation deleted'), 'default', array('class' => 'alert alert-success success'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function modulaciones()
    {
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
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $this->set(compact('datetimes', 'sites', 'mimos', 'log_mstations'));
    }

    public function modulaciones_x_sitio()
    {
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
        foreach ($log_mstations as $lms) {
            $results[$lms['Site']['id']]['Site'] = $lms['Site'];
            if (!array_key_exists('DlFec', $results[$lms['Site']['id']]) || !is_array($results[$lms['Site']['id']]['DlFec'])) {
                $results[$lms['Site']['id']]['DlFec'] = array();
            }
            $lms['DlFec']['cant'] = $lms[0]['cant'];
            $results[$lms['Site']['id']]['DlFec'][] = $lms['DlFec'];
        }
        $log_mstations = $results;

        $sites = $this->LogMstation->MsLogTable->Site->find('list');
        $mimos = $this->LogMstation->Mimo->find('list');
        $dl_fecs = $this->LogMstation->DlFec->find('list', array('fields' => array('DlFec.modulation', 'DlFec.line_color')));
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $this->set(compact('datetimes', 'sites', 'mimos', 'log_mstations', 'dl_fecs'));
    }

    public function graf_mimo()
    {
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
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $this->set(compact('datetimes', 'sites', 'mimos', 'log_mstations'));
        if ($this->request->is('ajax')) {
            $this->render("ajax_graf_mimo");
        }
    }

    public function usuarios_x_modulacion()
    {

        if (empty($this->paginate['conditions']['MsLogTable.datetime']) &&
                empty($this->paginate['conditions']['MsLogTable.datetime >=']) && empty($this->paginate['conditions']['MsLogTable.datetime <='])
        ) {
            $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
            $nuevafecha = strtotime('-2 day', strtotime($lastDatetime['Migration']['id']));
            $this->paginate['conditions']['MsLogTable.datetime BETWEEN ? and ?'] = array(
                date('Y-m-d H:i:s', $nuevafecha),
                $lastDatetime['Migration']['id']
            );
            unset($this->paginate['conditions']['MsLogTable.datetime']);
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
        foreach ($log_mstations as $lm) {
            $nlog[$lm['DlModulation']['modulation_type_id']][] = array(
                $lm['MsLogTable']['datetime'],
                $lm[0]['cant']
            );
        }
        $log_mstations = $nlog;
        unset($log_mstations["Series 1"]);

        // colocar los colores de cada linea
        $mdtypes = ClassRegistry::init('Sky.ModulationType')->find('list', array('fields' => array('id', 'line_color')));
        $dataColor = array();
        foreach ($log_mstations as $lllmmm => $llldata) {
            $dataColor[] = $mdtypes[$lllmmm];
        }

        //        $sites = $this->LogMstation->MsLogTable->Site->find('list'); 
//            $mimos = $this->LogMstation->Mimo->find('list');
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $sites = $this->LogMstation->MsLogTable->Site->find('list');
        $mimos = $this->LogMstation->Mimo->find('list');
        $this->set(compact('datetimes', 'log_mstations', 'sites', 'mimos', 'dataColor'));
    }

    public function max_usuarios_x_modulacion3()
    {

        if (empty($this->paginate['conditions']['MsLogTable.datetime']) &&
                empty($this->paginate['conditions']['MsLogTable.datetime >=']) && empty($this->paginate['conditions']['MsLogTable.datetime <='])
        ) {
            $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
            $nuevafecha = strtotime('-7 day', strtotime($lastDatetime['Migration']['id']));
            $fechaDesde = date('Y-m-d H:i:s', $nuevafecha);
            $fechaHasta = $lastDatetime['Migration']['id'];
            $this->paginate['conditions']['MsLogTable.datetime BETWEEN ? and ?'] = array(
                $fechaDesde,
                $fechaHasta
            );
            unset($this->paginate['conditions']['MsLogTable.datetime']);
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
            $auxCant = (int) $aa[0]['cant'];
            if (array_key_exists($auxKey, $results)) {
                if ($results[$auxKey]['cant'] < $auxCant) {
                    $results[$auxKey] = array(
                        'cant' => $auxCant,
                        'datetime' => $aa['MsLogTable']['datetime'],
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
        foreach ($results as $r) {
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
            'fields' => array('id', 'line_color'),
            'order' => 'ModulationType.order'
        ));
        $nlog = $mdtypes;
        foreach ($nlog as &$nnnnl) {
            $nnnnl = array();
        }
        foreach ($log_mstations as $lm) {
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
        foreach ($log_mstations as $lllmmm => $llldata) {
            $dataColor[] = $mdtypes[$lllmmm];
        }

        $labels = array();
        $cantTot = count($log_mstations['16QAM']);
        $i = -1;
        while ($i++ < $cantTot - 1) {
            $sumaTot = $log_mstations['16QAM'][$i][1] + $log_mstations['64QAM'][$i][1] + $log_mstations['QPSK'][$i][1];
            $labels64[$i] = round($log_mstations['64QAM'][$i][1] / $sumaTot * 10000) / 100 . '%';
            $labels16[$i] = round($log_mstations['16QAM'][$i][1] / $sumaTot * 10000) / 100 . '%';
            $labelsqpsk[$i] = round($log_mstations['QPSK'][$i][1] / $sumaTot * 10000) / 100 . '%';
        }
//            $mimos = $this->LogMstation->Mimo->find('list');
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $sites = $this->LogMstation->MsLogTable->Site->find('list');
        $mimos = $this->LogMstation->Mimo->find('list');
        $this->set(compact('labels64', 'labels16', 'labelsqpsk', 'datetimes', 'log_mstations', 'sites', 'mimos', 'dataColor', 'fechaDesde', 'fechaHasta'));
    }

    public function max_usuarios_x_modulacion2()
    {
        $conditionsMs = '1 = 1';
        
        
        if ( empty($this->params->query['datetime_from']) && empty($this->params->query['datetime_to']) ){
            $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
            $lastFechaTime = strtotime($lastDatetime['Migration']['id']);
            $nuevafecha = strtotime('-7 day', $lastFechaTime);
            $fechaDesde = date('Y-m-d', $nuevafecha);
            $fechaHasta = date('Y-m-d', $lastFechaTime);
        }
        
        if (!empty($this->params->query['datetime_from'])) {
            $fechaDesde = $this->params->query['datetime_from'];
        }
        if (!empty($this->params->query['datetime_to'])) {
            $fechaHasta = $this->params->query['datetime_to'];
        } 


        if (!empty($fechaDesde)) {
            $conditionsMs .= " AND DATE(MsLogTable.datetime) >= '$fechaDesde'";
        }

        if (!empty($fechaHasta)) {
            $conditionsMs .= " AND DATE(MsLogTable.datetime) <= '$fechaHasta'";
        }

        $orderBy = $groupBy = "date, modulation";

        $fields = "*";

        $sqlQuery = "
SELECT * 
FROM (
	SELECT max(cant) maxcant, DATE(datetime) maxdate
	FROM (
		SELECT 
			sum(MsLogTable.total_ms) as cant, 
			sum(MsLogTable.total_ms_qpsk) as QPSK, 
			sum(MsLogTable.total_ms_16qam) as 16QAM, 
			sum(MsLogTable.total_ms_64qam) as 64QAM, 
			MsLogTable.datetime	
		FROM
			sky_ms_log_tables as MsLogTable
		WHERE
			$conditionsMs
		GROUP BY
			MsLogTable.datetime
		) as sumas
	GROUP BY DATE(datetime)
) as maxims
left join 
	(
	SELECT 
		sum(MsLogTable.total_ms) as cant, 
		sum(MsLogTable.total_ms_qpsk) as QPSK, 
		sum(MsLogTable.total_ms_16qam) as 16QAM, 
		sum(MsLogTable.total_ms_64qam) as 64QAM, 
		MsLogTable.datetime	
	FROM
		sky_ms_log_tables as MsLogTable
	WHERE
		$conditionsMs
	GROUP BY
		MsLogTable.datetime
	) as s2 on (s2.cant = maxcant AND DATE(s2.datetime) = maxdate)
group by date(datetime)             
        ";

        // detectar maximos, primeo buscar todos
        $listMaxCounts = $this->LogMstation->query($sqlQuery);
        $fechas = crear_fechas($fechaDesde, $fechaHasta);

        $mdtypes = ClassRegistry::init('Sky.ModulationType')->find('list', array(
            'fields' => array('id', 'line_color'),
            'order' => 'ModulationType.order DESC'
        ));


        // rearmar array de resultados por modulation y date
        $nlog = array();
        foreach ($listMaxCounts as $mc) {
            foreach ($mdtypes as $mdTypeId => $lineColor) {
                $nlog[$mdTypeId][$mc['maxims']['maxdate']] = $mc['s2'][$mdTypeId];
            }
        }

        //arma el nuevo listado de resultados ordenados
        $resCounts = array();
        //para crear el array de colores de las lineas segun modulacion
        $dataColor = array();
        //nombre de los tipos de modulacion listados
        $modTypes = array();
        foreach ($mdtypes as $mdTypeId => $lineColor) {
            // completar el color de la linea
            $dataColor[] = $lineColor;
            $modTypes[] = $mdTypeId;
            //inicializar array de fechas para esta modulacion
            $modfechas = array();
            foreach ($fechas as $fech) {
                // colocar cero si esa fecha no tiene valor
                $modfechas[] = empty($nlog[$mdTypeId][$fech]) ? 0 : $nlog[$mdTypeId][$fech];
            }
            // coloco todo el array de fechas para la modulacion
            $resCounts[$mdTypeId] = $modfechas;
        }

        //hack para esto que aparece y no quiero que se muestre
//        unset($log_mstations["Series 1"]);
        // calcular porcentajes por fecha
        $labels = array();
        $i = -1;
        // array con todas las sumas de cada dia
        $sumasTotales = array();
        foreach ($fechas as $indice => $fech) {
            $sumaTot = 0;

            // sumar el total
            foreach ($mdtypes as $modType => $lcolor) {
                $sumaTot += $resCounts[$modType][$indice];
            }
            $sumasTotales[] = $sumaTot;

            // calcular valores porcentuales
            foreach ($mdtypes as $modType => $lcolor) {
                if ($sumaTot > 0) {
                    $labels[$modType][] = round($resCounts[$modType][$indice] / $sumaTot * 10000) / 100;
                } else {
                    $labels[$modType][] = 0;
                }
            }
        }

        $this->request->data['LogMstation']['datetime_from'] = $fechaDesde;
        $this->request->data['LogMstation']['datetime_to'] = $fechaHasta;

        //armo los labels para mostrar
        $this->set('log_mstations', $resCounts);

        $this->set('aFechas', $fechas);
        $datetimes = $this->LogMstation->MsLogTable->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $sites = $this->LogMstation->MsLogTable->LogMstation->MsLogTable->Site->find('list');
        $mimos = $this->LogMstation->MsLogTable->LogMstation->Mimo->find('list');
        $this->set(compact('sumasTotales', 'modTypes', 'labels', 'datetimes', 'sites', 'mimos', 'dataColor', 'fechaDesde', 'fechaHasta'));
    }
    
    
    public function max_usuarios_x_modulacion()
    {
        $conditionsMs = '1 = 1';
        
        
        if ( empty($this->params->query['datetime_from']) && empty($this->params->query['datetime_to']) ){
            $lastDatetime = $this->LogMstation->MsLogTable->Migration->find('first', array('order' => 'id DESC'));
            $lastFechaTime = strtotime($lastDatetime['Migration']['id']);
            $nuevafecha = strtotime('-7 day', $lastFechaTime);
            $fechaDesde = date('Y-m-d', $nuevafecha);
            $fechaHasta = date('Y-m-d', $lastFechaTime);
        }
        
        if (!empty($this->params->query['datetime_from'])) {
            $fechaDesde = $this->params->query['datetime_from'];
        }
        if (!empty($this->params->query['datetime_to'])) {
            $fechaHasta = $this->params->query['datetime_to'];
        } 


        if (!empty($fechaDesde)) {
            $conditionsMs .= " AND DATE(MsLogTable.datetime) >= '$fechaDesde'";
        }

        if (!empty($fechaHasta)) {
            $conditionsMs .= " AND DATE(MsLogTable.datetime) <= '$fechaHasta'";
        }

        $orderBy = $groupBy = "date, modulation";

        $fields = "*";

        $sqlQuery = "
SELECT * 
FROM (
	SELECT max(cant) maxcant, DATE(datetime) maxdate
	FROM (
		SELECT 
			sum(MsLogTable.total_ms) as cant, 
			sum(MsLogTable.total_ms_qpsk) as QPSK, 
			sum(MsLogTable.total_ms_16qam) as 16QAM, 
			sum(MsLogTable.total_ms_64qam) as 64QAM, 
			MsLogTable.datetime	
		FROM
			sky_ms_log_tables as MsLogTable
		WHERE
			$conditionsMs
		GROUP BY
			MsLogTable.datetime
		) as sumas
	GROUP BY DATE(datetime)
) as maxims
left join 
	(
	SELECT 
		sum(MsLogTable.total_ms) as cant, 
		sum(MsLogTable.total_ms_qpsk) as QPSK, 
		sum(MsLogTable.total_ms_16qam) as 16QAM, 
		sum(MsLogTable.total_ms_64qam) as 64QAM, 
		MsLogTable.datetime	
	FROM
		sky_ms_log_tables as MsLogTable
	WHERE
		$conditionsMs
	GROUP BY
		MsLogTable.datetime
	) as s2 on (s2.cant = maxcant AND DATE(s2.datetime) = maxdate)
group by date(datetime)             
        ";

        // detectar maximos, primeo buscar todos
        $listMaxCounts = $this->LogMstation->query($sqlQuery);

        // listado de fechas que aparecen en este grafico
        $fechasConTotales = array();
        foreach ($listMaxCounts as &$lmc) {
            // rearmar valores porcentuales
            $lmc['porcent'] = array(
                    'QPSK' => 0,
                    '16QAM' => 0,
                    '64QAM' => 0,
                );
            if ( $lmc['s2']['cant'] > 0  ) {
                $lmc['porcent'] = array(
                    'QPSK' =>    round($lmc['s2']['QPSK'] / $lmc['s2']['cant'] * 10000) / 100,
                    '16QAM' =>    round($lmc['s2']['16QAM'] / $lmc['s2']['cant'] * 10000) / 100,
                    '64QAM' =>    round($lmc['s2']['64QAM'] / $lmc['s2']['cant'] * 10000) / 100,
                );
            }
            
            // crear listado de fechas
            $fechasConTotales[$lmc['maxims']['maxdate']] = $lmc['maxims']['maxcant'];
        }
        
        $mdtypes = ClassRegistry::init('Sky.ModulationType')->find('list', array(
            'fields' => array('id', 'line_color'),
            'order' => 'ModulationType.order DESC'
        ));


        // crear linea para grafico por modulacion con coordenadas: fecha, cantidad
        $nlog = array();
        //crear labels con valores porcentuales
        $labels = array();
        foreach ($listMaxCounts as $mc) {
            foreach ($mdtypes as $mdTypeId => $lineColor) {
                $nlog[$mdTypeId][] = array(
                    $mc['maxims']['maxdate'], 
                    $mc['s2'][$mdTypeId],
                    $mc['porcent'][$mdTypeId]."% (".$mc['s2'][$mdTypeId].")" // label
                    );
            }
        }

        //crear el array de colores de las lineas segun modulacion
        $dataColor = array_values($mdtypes);
        
        //listar nombre de los tipos de modulacion listados
        $modTypes = array_keys($mdtypes);
       

        $this->request->data['LogMstation']['datetime_from'] = $fechaDesde;
        $this->request->data['LogMstation']['datetime_to'] = $fechaHasta;

        $this->set('log_mstations', $nlog);
        $this->set('fechas', $fechasConTotales);
        $this->set('todasfechas', crear_fechas($fechaDesde, $fechaHasta));
        
        $datetimes = $this->LogMstation->MsLogTable->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $sites = $this->LogMstation->MsLogTable->LogMstation->MsLogTable->Site->find('list');
        $mimos = $this->LogMstation->MsLogTable->LogMstation->Mimo->find('list');
        $this->set(compact('modTypes', 'labels', 'datetimes', 'sites', 'mimos', 'dataColor', 'fechaDesde', 'fechaHasta'));
    }
    
    
    public function view ($id) {
        if (!$id) {
            $this->Session->setFlash(__d('croogo', 'Invalid id'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('logMstation', $this->LogMstation->read(null, $id));
    }
    
    
    public function show_cloned_mac () {
       
//         $this->Prg->commonProcess();
//         $condi = $this->LogMstation->parseCriteria($this->request->query);
//         debug($this->paginate);
        
         
         $this->paginate['fields'] = array(                
                'MsLogTable.datetime',
                'LogMstation.mstation_id',
                'COUNT( LogMstation.mstation_id ) '
            );
         
        $this->paginate['group'] = 'MsLogTable.datetime, LogMstation.mstation_id HAVING COUNT( LogMstation.mstation_id ) >1';
        
        $this->paginate['contain'] = array(
                'MsLogTable'
            );
        
        
        $this->set('logMstations', $this->paginate());
        
        
        $sites = $this->LogMstation->MsLogTable->Site->find('list');
        $datetimes = $this->LogMstation->MsLogTable->Migration->find('list', array('fields' => array('id', 'id'), 'order' => 'id DESC', 'limit' => '100'));
        $mimos = $this->LogMstation->Mimo->find('list');
        $fecs = $this->LogMstation->UlFec->find('list', array('fields' => array('id', 'full_name')));
        $this->set(compact('datetimes', 'sites', 'mimos', 'log_mstations'));
        
        
    }

}
