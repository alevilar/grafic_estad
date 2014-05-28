<?php

/**
 * @property DataCounter $DataCounter Metrics Data Model
 * @property Counter $Counter Model
 * @property Kpi $Kpi 
 * @property HourlyCounter $HourlyCounter
 * @property DataDay $DataDay
 * @property DailyValue $DailyValue
 */
class MigrateShell extends AppShell
{

    public $uses = array(
        'Skpi.DataCounter',
        'Skpi.Counter', 
        'Skpi.Kpi', 
        'Skpi.HourlyCounter',
        'Skpi.DataDay',
        'Skpi.DailyValue',
        'Sky.Carrier',
        'Skpi.SiteMaximsDailyValue',
        );   
    
    
    public function startup () {
        parent::startup();
        
         $this->out("KPI MIGRATION\n
<warning>,==                 |)             O  O
                   (( ^\                |       ...''  |  |
               (`.  ;`. )               | .'''''  __   |  | .....''
                `.`.uu ;`'             O .'      |--|,.|__|'
                  `   | ( ,/,         .`     ....|''|  '--'
                 /|\`. J)`  ,      ..'      '    | O
                 \|O\;| _`-'   __               O
              ,.__`-| |( ^)+++( ^)                      O
              |/  `._@,/|| ||| ||^_,^.      .,...,...,..|,...,.
              (  _,'_((' `.,||-< ) //                   |
              |`^ /MM  ^\\\\||-|\_//                    |)
             /!!!:M  MM/(  |||  )\
            |!!!!; MM (  \_|||_/  )
            |!!!/MM  MM`-.(__(_.-'
           /!!!;M  MM  MM ;|
          /!!!<  MM_,-o-./!|
        ,'!!!!!`''--'^^'/!!!\
       /,'.-._/    _,--/!!!!|
      |/,'_ +__,-'!!  :-'^`\|
      o88o.-'  `\"\"\"'| /    |/
     (8888;        .\(__,o.
    __Y88;_________,888888P______________________________alevilar</warning>");
         
         
         
        
    }


    /**
 * Display help/options
 */
    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser->description(__d('sky', 'Sky KPI Migration'))           
            ->addSubCommand('start', array(
                'help' => __d('sky', 'Inicia migración desde la última fecha que se hizo hasta ahora'),
                'parser' => array(
                        // 'description' => 'Inicia migración desde la última fecha que se hizo hasta ahora',
                        'options' => array(
                            'force' => array(
                                'short' => 'f',
                                'boolean' => true,
                                'help' => __('Fuerza para que se actualicen todos los datos, sin importar cuando fue la última actualización')
                            )
                        )
                    )
                )
            )
            ->addSubcommand('day', array(
                    'help' => 'Migrar o actualizar una fecha puntual (formato: YYYY-MM-DD)',
                    'parser' => array(
                        'description' => 'Migrar o actualizar una fecha puntual (formato: YYYY-MM-DD)',
                        'arguments' => array(
                            'fecha' => array(
                                'required' => true,
                                'help' => 'Fecha puntual que se desea migrar o actualizar formato: YYYY-MM-DD',
                            ),
                        ),
                    ),
            ));
        return $parser;
    }

    

    public function start()
    {    
        
        if ( !$this->params['force'] ) {
            $lastDay = $this->DataDay->find('first', array(
                    'fields' => array(
                        'DataDay.ml_date',
                    ),
                    'order' => array(
                        'DataDay.ml_date DESC' 
                    )
            ));
        }
        if ( empty($lastDay) ) {
            // primera vez que corre el script
            $dateFrom = '2014-01-01';
        } elseif ( $lastDay == date('Y-m-d')) {
            $dateFrom = date('Y-m-d', strtotime('-1 day'));
        } else {
            $dateFrom = $lastDay['DataDay']['ml_date'];
        }
        
        $dateToday = date('Y-m-d');

        $cantMetrics = $this->DataCounter->find('count', array(
            'conditions' => array(
                    'DATE(date_time) >' => $dateFrom,
                    'DATE(date_time) <' => $dateToday
            ),
        ));
        
        
        $cantMetricsToday = $this->DataCounter->find('count', array(
            'conditions' => array(
                    'DATE(date_time)' => $dateToday,
            ),
        ));

        $totMetricas = $cantMetrics + $cantMetricsToday;
        
        $this->out("Hay $totMetricas metricas desde la última migración: $dateFrom");
        
        
        if ( $totMetricas ) {
            $this->out("\n*-*-*-*-*-*-Iniciando actualizacion de Maximos Traficos DL y UL");
            $this->__saveMaximsFromDate( $dateFrom );
            $this->out("\n*-*-*-*-*-*-Iniciando migracion de calculos KPI");
            $this->__calculateKpisDesde( $dateFrom );
            
        } 

        if ( $cantMetricsToday ) {
            $this->__saveMaximsOfDate( $dateToday );
            $this->__calculateKpisDelDia( $dateToday );
            $this->out("\nActualizando datos de HOY");
        }

        if ( !$totMetricas ) {
            $this->out("\nNada que migrar, terminando....\n\n\n");
        }        
        
    }
    
    
    public function day() {
        $datein = $this->args[0];
        if( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $datein)) {
            $this->__calculateKpisDelDia($datein);
        }else{
            $this->out('<error>Formato de fecha inválida: ' . $datein. ' se debe ingresar YYYY-mm-dd</error>');
        }
        
        
    }
    
   

    private function __calculateKpisgetMetricConds ( $conds ) {
        // listar todos los KPIS
        $kpis = $this->Kpi->find('all', array(
            'recursive' => -1,
        ));
        
        // Ejecutar Transaccion
        $this->DailyValue->getDataSource()->begin();
        
        // inicializar valores de errores para procesar al final
        $saveErrors = array();
        
        try {
            // recorrer cada KPI para ir buscando su valor y guardar
            foreach ($kpis as $k) {
                $this->__saveKpi($k, $conds);
            }
        } catch (Exception $e) {
            // Hay error
            $this->DailyValue->getDataSource()->rollback(); 
            $this->out("<error>".$e->getMessage()."</error>");
        }

        // Commit Changes
        $this->out("<success>Se guardaron todos los registros correctamente</success>");
        $this->DailyValue->getDataSource()->commit();       
    }


    /**
     * @param $k Kpi Model array
     * @param $conds array conditiones de busqueda para el modelo DataCounter
     */
    private function __saveKpi ( $k, $conds ) {

        // setar nombre del KPI
            $kpiName = $k['Kpi']['name'];
            
            if ( empty( $k['Kpi']['sql_formula'] ) ) {
                // Si no tiene formula seguir con los otros KPIS                
                $this->out("<warning>El KPI '$kpiName' no tiene formula SQL. No se calcula nada</warning>");
                continue;
            }
            
            // poner la formula como field del SQL statement
            if ( substr( $k['Kpi']['sql_formula'], 0, 3 ) === "fn:" ) {
                // la formula es una funcion
                $fname = substr($k['Kpi']['sql_formula'], 3);
                if ( !method_exists($this, $fname) ) {
                    throw new Exception('No existe la funcion '.$fname);
                }

                $dataMetric = call_user_func_array(array($this, $fname), array($conds));
            } else {
                $fd = $k['Kpi']['sql_formula'];  
                // buscar los datos a migrar de la tabla de metricas
                $dataMetric = $this->DataCounter->find('all', array(
                    'fields' => array(
                          $fd." as val",  
                          'DATE(date_time) as ml_datetime',
                          'objectno',
                    ),
                    'group' => array('objectno', 'ml_datetime'),
                    'conditions' => $conds,
                ));  
            }


            
            $this->out("El KPI $kpiName tiene ".count($dataMetric)." registros por migrar");
            
            // por cada dato a migrar
            foreach ( $dataMetric as $md ) {
                $this->__saveDataCount($k, $md);
            }
    }


    public function __saveMaximsGenericByDay ( $day ) {        
        $sts = $this->__get_sites_maxims_for_day ( $day );

        if (empty($sts)) {
            return -1;
        }
        $smdvs = array();
        foreach ( $sts as $s ) {
            $newSmdv = array('SiteMaximsDailyValue' => array(
                    'site_id' => $s['Site']['id'],
                    'ml_datetime' => $s['DataCounter']['date_time'],
                    'dl_value' => $s[0]['dl_val'],
                    'ul_value' => $s[0]['ul_val'],
                ));


            // verificar, porque si ya existe lo tengo que actualizar
            $siteValue = $this->SiteMaximsDailyValue->find('first', array(
                'conditions' => array(
                    'DATE(SiteMaximsDailyValue.ml_datetime)' => date('Y-m-d', strtotime( $s['DataCounter']['date_time'])),
                    'SiteMaximsDailyValue.site_id' => $s['Site']['id'],
                    )
            ));
            if ( !empty($siteValue) ) {
                $newSmdv['SiteMaximsDailyValue']['id'] = $siteValue['SiteMaximsDailyValue']['id'];
            }


            $smdvs[] = $newSmdv;
        }        
        if ( !$this->SiteMaximsDailyValue->saveAll($smdvs) ) {
            $this->log(print_r($this->SiteMaximsDailyValue->validationErrors, true));
            throw new Exception("Error al guardar SiteMaximsDailyValue");
        }
    }

    public function __saveMaximsOfDate ( $date ) {
       
        $this->__saveMaximsGenericByDay( $date);
    }

    public function __saveMaximsFromDate ( $date ) {
        $days = crear_fechas($date, 'now');
        foreach ($days as $day ) {
            $this->__saveMaximsGenericByDay( $day);
        }
    }


    public function __get_sites_maxims_for_day ( $date ) {
        $sites = $this->Carrier->Sector->Site->find('list');
        $nsites = array();
        foreach ( $sites as $sId=>$sName ) {

            $dvals = $this->__get_maxim_for_site_n_day($sId, $date);            

            if (!empty($dvals)) {                
                $dvals['Site']['id'] = $sId;
                $dvals['Site']['name'] = $sName;
                $nsites[] = $dvals;
            }
        }
        return $nsites;
    }


    public function __get_maxim_for_site_n_day ( $site_id, $day ) {
        $objectnos = $this->Carrier->Sector->Site->listCarriers( $site_id, 'objectno' );
        $conds = array(
            'objectno' => $objectnos,
            'DATE(date_time)' => $day,
            );


        // buscar los datos a migrar de la tabla de metricas
        $this->Counter->id = SK_COUNTER_UL_AVG;
        $colnameUl = $this->Counter->field('col_name');

        $this->Counter->id = SK_COUNTER_DL_AVG;
        $colnameDl = $this->Counter->field('col_name');

        $db = $this->DataCounter->getDataSource();
        $data = $this->DataCounter->find('first', array(
                'fields' => array(
                      "(SUM(DataCounter.$colnameDl) + SUM(DataCounter.$colnameUl/1000)) as val",
                      "SUM(DataCounter.$colnameDl) as dl_val",
                      "SUM(DataCounter.$colnameUl/1000) as ul_val",
                      'DataCounter.date_time as date_time', // SHOW DATETIME
                ),
                'conditions' => $conds,
                'order'      => array('val DESC'),
                'group' => array('DataCounter.date_time'),
            ));
        return $data;
    }


    /**
     *  
     *  @param $k Kpi Model array
     *  @param $md Metric Data DataCount Model Array
     */
    private function __saveDataCount ( $k, $md ) {
        // setear el valor del calculo del KPI
                $value = $md[0]['val'];           
                $kpiName = $k['Kpi']['name'];
                $this->Carrier->recursive = -1;
                $carrier = $this->Carrier->findByObjectno($md['DataCounter']['objectno']);

                // tiene que ser un valor numerico, si viene NULL u otra cosa, no lo tengo en cuenta
                if ( !is_null($value) ) {

                    $dataDay = $this->DataDay->find('first', array(
                        'recursive' => -1,
                        'conditions' => array(
                            'DataDay.ml_date'    => $md[0]['ml_datetime'],
                            'DataDay.carrier_id' => $carrier['Carrier']['id'], 
                        ),
                    ));
                    
                    if ( empty($dataDay) ) {
                        // si no existia previamente crear nueva fecha
                        $this->DataDay->create();
                        $dataDay['DataDay'] = array(
                            'ml_date' => $md[0]['ml_datetime'],
                            'carrier_id' => $carrier['Carrier']['id'],
                        );
                        $dataDay['DailyValue'] = array(
                            'kpi_id' => $k['Kpi']['id'],
                            'value'  => $value,
                        );
                    } else {
                        // si existia hay que sobreescribir los datos
                        
                        // ahora ver si existe el kpi para esa fecha
                        $kdv = $this->DailyValue->find('first', array(
                            'conditions' => array(
                                'DailyValue.data_day_id' => $dataDay['DataDay']['id'],
                                'DailyValue.kpi_id' => $k['Kpi']['id'],
                            )
                        ));
                        if ( !empty($kdv) ) {
                            // existe el KPI entonces sobreescribo
                            $dataDay['DailyValue'] = $kdv['DailyValue'];                            
                        } else {
                            // no existe, entonces crear uno nuevo
                            $this->DailyValue->create();
                            $dataDay['DailyValue']['kpi_id'] = $k['Kpi']['id'];
                            
                        }       
                        // modificar el valor, aunque existiese o sea nuevo
                        $dataDay['DailyValue']['value'] = $value;
                    }
                    
                    
                    if ( !$this->DailyValue->saveAssociated( $dataDay ) ) {
                        $saveErrors[] = $dataDay;

                        $this->log("--------- Error al migrar DailyValue --------");
                        $this->log(print_r($dataDay));
                        $this->log(print_r($this->DataDay->validationErrors, true));
                        $this->log(print_r($this->DailyValue->validationErrors, true));
                        throw new Exception('Error al guardar DailyValue');
                    }
                } else {
                    $this->out("<warning>$kpiName retornó un valor que es null. No se guardará valor para este KPI.</warning>");
                }
    }
    
     private function __calculateKpisDelDia ( $date ) {
        $conds = array( 'DATE(date_time)' => $date);
        $this->__calculateKpisgetMetricConds($conds);
    }
    
   

    private function __calculateKpisDesde ( $date ) {
        $conds = array( 'DATE(date_time) >' => $date);
        $this->__calculateKpisgetMetricConds($conds);
    }
    
}