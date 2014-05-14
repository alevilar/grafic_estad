<?php

/**
 * @property MetricsData $MetricsData Metrics Data Model
 * @property KpiCounter $KpiCounter Model
 * @property Kpi $Kpi 
 * @property KpiHourlyCounter $KpiHourlyCounter
 * @property KpiDataDay $KpiDataDay
 * @property KpiDailyValue $KpiDailyValue
 */
class MigrateShell extends AppShell
{

    public $uses = array(
        'Skpi.MetricsData',
        'Skpi.KpiCounter', 
        'Skpi.Kpi', 
        'Skpi.KpiHourlyCounter',
        'Skpi.KpiDataDay',
        'Skpi.KpiDailyValue',
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
    

    public function main()
    {    
        
        
        $lastDay = $this->KpiDataDay->find('first', array(
                'fields' => array(
                    'KpiDataDay.ml_date',
                ),
                'order' => array(
                    'KpiDataDay.ml_date DESC' 
                )
        ));
        
        if ( empty($lastDay) ) {
            // primera vez que corre el script
            $dateFrom = '2014-01-01';
        } else {
            $dateFrom = $lastDay['KpiDataDay']['ml_date'];
        }
        
        $cantMetrics = $this->MetricsData->find('count', array(
            'conditions' => array(
                    'DATE(date_time) >' => $dateFrom
            ),
        ));
        $this->out("Hay $cantMetrics metricas desde la última migración: $dateFrom");
        
        
        if ( $cantMetrics ) {
            $this->__calculateKpisDesde( $dateFrom );
        } else {
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
        $this->KpiDailyValue->getDataSource()->begin();
        
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
            $metricsData = $this->MetricsData->find('all', array(
                'fields' => array(
                      $fd." as val",  
                      'DATE(date_time) as ml_datetime',
                      'object_id',
                ),
                'conditions' => $conds,
            ));
            
            $this->out("El KPI $kpiName tiene ".count($metricsData)." registros por migrar");
            
            // por cada dato a migrar
            foreach ( $metricsData as $md ) {
                // setear el valor del calculo del KPI
                $value = $md[0]['val'];

                // tiene que ser un valor numerico, si viene NULL u otra cosa, no lo tengo en cuenta
                if ( !is_null($value) ) {
                    
                    $dataDay = $this->KpiDataDay->find('first', array(
                        'recursive' => -1,
                        'conditions' => array(
                            'KpiDataDay.ml_date'    => $md[0]['ml_datetime'],
                            'KpiDataDay.carrier_id' => 1, // HARDCODEADOOOOOOOOOOO
                        ),
                    ));
                    
                    if ( empty($dataDay) ) {
                        // si no existia previamente crear nueva fecha
                        $this->KpiDataDay->create();
                        $dataDay['KpiDataDay'] = array(
                            'ml_date' => $md[0]['ml_datetime'],
                            'carrier_id' => 1, // HARDCODEADOOOOOOOOOOO
                        );
                        $dataDay['KpiDailyValue'] = array(
                            'kpi_id' => $k['Kpi']['id'],
                            'value'  => $value,
                        );
                    } else {
                        // si existia hay que sobreescribir los datos
                        
                        // ahora ver si existe el kpi para esa fecha
                        $kdv = $this->KpiDailyValue->find('first', array(
                            'conditions' => array(
                                'KpiDailyValue.kpi_data_day_id' => $dataDay['KpiDataDay']['id'],
                                'KpiDailyValue.kpi_id' => $k['Kpi']['id'],
                            )
                        ));
                        if ( !empty($kdv) ) {
                            // existe el KPI entonces sobreescribo
                            $dataDay['KpiDailyValue'] = $kdv['KpiDailyValue'];                            
                        } else {
                            // no existe, entonces crear uno nuevo
                            $this->KpiDailyValue->create();
                            $dataDay['KpiDailyValue']['kpi_id'] = $k['Kpi']['id'];
                            
                        }       
                        // modificar el valor, aunque existiese o sea nuevo
                        $dataDay['KpiDailyValue']['value'] = $value;
                    }
                    
                    
                    if ( !$this->KpiDailyValue->saveAssociated( $dataDay ) ) {
                        debug($dataDay);
                        debug( $this->KpiDataDay->validationErrors );
                        debug( $this->KpiDailyValue->validationErrors );die;
                        $saveErrors[] = $dataDay;
                    }
                    
                } else {
                    $this->out("<warning>$kpiName retornó un valor que es null. No se guardará valor para este KPI.</warning>");
                }
            }
        }
        
        if ( count($saveErrors) ) {
            // Hay error
            $this->KpiDailyValue->getDataSource()->rollback();            
            throw new Exception('Nada fue guardado, hubo algun error al querer guardar el ' . count($saveErrors).' en KPI´s ');
        } else {
            // Commit Changes
            $this->out("<success>Se guardaron todos los registros correctamente</success>");
            $this->KpiDailyValue->getDataSource()->commit();
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