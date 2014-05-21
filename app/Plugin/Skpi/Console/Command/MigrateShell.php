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
            $this->__calculateKpisDesde( $dateFrom );
        } 

        if ( $cantMetricsToday ) {
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
        
        // recorrer cada KPI para ir buscando su valor y guardar
        foreach ($kpis as $k) {
            // setar nombre del KPI
            $kpiName = $k['Kpi']['name'];
            
            if ( empty( $k['Kpi']['sql_formula'] ) ) {
                // Si no tiene formula seguir con los otros KPIS                
                $this->out("<warning>El KPI '$kpiName' no tiene formula SQL. No se calcula nada</warning>");
                continue;
            }
            
            // poner la formula como field del SQL statement
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
            $this->out("El KPI $kpiName tiene ".count($dataMetric)." registros por migrar");
            
            // por cada dato a migrar
            foreach ( $dataMetric as $md ) {
                // setear el valor del calculo del KPI
                $value = $md[0]['val'];                
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
                        debug($dataDay);
                        debug( $this->DataDay->validationErrors );
                        debug( $this->DailyValue->validationErrors );
                        $saveErrors[] = $dataDay;
                    }
                    
                } else {
                    $this->out("<warning>$kpiName retornó un valor que es null. No se guardará valor para este KPI.</warning>");
                }
            }
        }
        
        if ( count($saveErrors) ) {
            // Hay error
            $this->DailyValue->getDataSource()->rollback();            
            throw new Exception('Nada fue guardado, hubo algun error al querer guardar el ' . count($saveErrors).' en KPI´s ');
        } else {
            // Commit Changes
            $this->out("<success>Se guardaron todos los registros correctamente</success>");
            $this->DailyValue->getDataSource()->commit();
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