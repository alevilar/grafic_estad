<?php

class DataMigration{
    
    /**
     * Array con todas las lineas leidas del archivo
     * 
     * tiene el formato de KEY=>Value
     * 
     * donde el Key es una variable constante Ej: SK_INICIO
     * y el value es esa linea EJ: "DSP ALLMSINFO:SECTORID=1,CARRIERID=0;"
     * @var array 
     */
    public $raw = array();
    
    public $fileName = '';
    public $site = '';
    public $sector = '';
    public $carrier = '';
    public $fecha = '';
    
    public $results = 0;
    
    
    public $tableFieldsToPattern = array(
            'Site.name' => PT_SITE,
            'Sector.name' => PT_SECTOR,
            'Carrier.name' => PT_CARRIER,
            'MsLogTable.ms_datetime' => PT_FECHA,
            'MsLogTable.om_id' => PT_OM,
            'MsLogTable.comand_number' => PT_COMANDO_ID,
            'Retcode.name' => PT_RETCODE,
            'Retcode.code' => PT_RETCODE_ID,
    );
            
    
    /**
     * Campos de la BBDD
     */
    public $msLogTableData = array(
        'Site' => array (
            'name' => null,
        ),
        'Sector' => array (
            'name' => null,
        ),
        'Carrier' => array (
            'name' => null,
        ),
        'Retcode' => array (
            'code' => null,
            'name' => null,
        ),
        
        'MsLogTable' => array(
            'site_id' => null, // mandatory
            'sector_id' => null,
            'carrier_id' => null,
            'datetime' => null,
            'ms_datetime' => null,
            'om_id' => null,
            'comand_number' => null,
            'retcode_id' => null, // mandatory            
        ),
        
        // Ms Data para guardar segun array data de Cakephp
        'LogMstation' => array(
            
        ), 
    );
    
    
    /**
     * Campos de la tabla Mstation
     * en el orden que vinen en el archivo a migrar
     * 
     * @var array
     */
    public $msFields = array(
        'sector_id',
        'carrier_id',
        'mstation_id',
        'status_id',
        'mstation_pwr',
        'dl_cinr',
        'ul_cinr',
        'dl_rssi',
        'ul_rssi',
        'dl_fec_id',
        'ul_fec_id',
        'dl_repetitionfatctor',
        'ul_repetitionfatctor',
        'mimo_id',
        'benum',
        'nrtpsnum',
        'rtpsnum',
        'ertpsnum',
        'ugsnum',
        'ul_per_for_an_ms',
        'ni_value',
        'dl_traffic_rate',
        'ul_traffic_rate',
    );
    
    /**
     * Convierte los parametros en un objecto temporal que 
     * se va adaptando a la forma Cake para luego ser guardado en BD
     * 
     * @param string $filename nombre del archivo donde se saco la data
     * @param array $data
     */
    public function __construct($filename, $data)
    {
        $this->raw = $data;
        $this->fileName = $filename;
        $this->buildData();
    }
    
    public function checkData() {       
        if ( !$this->checkNumReports() ) {
            return false;
        }
        if ( !$this->checkCantMs() ) {
            return false;
        }
        return true;
    }
    
    private function checkCantMs () {
        $cantMs = count($this->getMs());
        $cantResults = $this->getNumberOfResults();
        
        if ( $cantMs !=  $cantResults) {  
            throw new Exception("No coinciden los MS parseados ($cantMs) con lo que indican los reportes ($cantResults)");
        }
        return true;
    }
    
    private function buildData () {
        foreach ($this->tableFieldsToPattern as $field=>$pattern) {
            $ff = explode(".", $field);
            if ( preg_match($pattern, $this->raw, $match) ) {                
                $this->msLogTableData[$ff[0]][$ff[1]] = trim($match[1]);
            }
        }
        
        $this->msLogTableData['MsLogTable']['datetime'] = $this->getDateTimeFromFilename();
        
        $this->getMs();
    }
    
    
    private function checkNumReports () {
        $matchReport = get_match_pattern(PT_REPORTS, $this->raw);
        if ( $matchReport ) {
            get_match_pattern(PT_NUMBER_RESULTS, $this->raw, $match);            
            if ( count($match[1]) != $matchReport) {
                throw new Exception("No coincide la cantidad de reportes el dato recogido del parseo");
            }
        }
        
        return true;
    }
    
    /**
     * Me devuelve los MS parseados
     * @return array of LogMstation tipo Cake
     */
    public function getMs () {
        if (empty($this->msLogTableData['LogMstation'])) {
            $this->buildMs();
        }
        
        return $this->msLogTableData['LogMstation'];
    }
    
    private function __getDatAfterEqual ($line) {
        preg_match('/(.*=  )(.+)/', $this->raw[$line], $match);
        return trim($match[2]);
    }
    
    
    private function __buildFor1Row () {        
            $lFields = array(
                'sector_id' => get_match_pattern(PT_MS_SECTOR_ID, $this->raw),
                'carrier_id' => get_match_pattern(PT_MS_CARRIER_ID, $this->raw),
                'mstation_id' => get_match_pattern(PT_MS_MSID, $this->raw),
                'status_id' => get_match_pattern(PT_MS_STATUS, $this->raw),
                'mstation_pwr' => get_match_pattern(PT_MS_PWR, $this->raw),
                'dl_cinr' => get_match_pattern(PT_MS_DLCINR, $this->raw),
                'ul_cinr' => get_match_pattern(PT_MS_ULCINR, $this->raw),
                'dl_rssi' => get_match_pattern(PT_MS_DLRSSI, $this->raw),
                'ul_rssi' => get_match_pattern(PT_MS_ULRSSI, $this->raw),
                'dl_fec_id' => get_match_pattern(PT_MS_DLFEC, $this->raw),
                'ul_fec_id' => get_match_pattern(PT_MS_ULFEC, $this->raw),
                'dl_repetitionfatctor' => get_match_pattern(PT_MS_DLREPETITIONFATCTOR, $this->raw),
                'ul_repetitionfatctor' => get_match_pattern(PT_MS_ULREPETITIONFATCTOR, $this->raw),
                'mimo_id' => get_match_pattern(PT_MS_DLMIMOFLAG, $this->raw),
                'benum' => get_match_pattern(PT_MS_BENUM, $this->raw),
                'nrtpsnum' => get_match_pattern(PT_MS_NRTPSNUM, $this->raw),
                'rtpsnum' => get_match_pattern(PT_MS_RTPSNUM, $this->raw),
                'ertpsnum' => get_match_pattern(PT_MS_ERTPSNUM, $this->raw),
                'ugsnum' => get_match_pattern(PT_MS_UGSNUM, $this->raw),
                'ul_per_for_an_ms' => get_match_pattern(PT_MS_ULPER, $this->raw),
                'ni_value' => get_match_pattern(PT_MS_NIVALUE, $this->raw),
                'dl_traffic_rate' => get_match_pattern(PT_MS_DLTRAFFICRATE, $this->raw),
                'ul_traffic_rate' => get_match_pattern(PT_MS_ULTRAFFICRATE, $this->raw),
            );
            
            $nfields= array();
            foreach ($lFields as $fname=>$ff) {
                if (!empty($ff)) {
                    $nfields[$fname] = $ff;
                }
            }
            $data[] = $nfields;
            return $data;
    }
    
    /**
     * Parsea los MS
     * @throws Exception
     */
    public function buildMs () {
        $data = array();
        $x = 0;
        
        if ( preg_match(PT_TAG_REPORT, $this->raw) ) {
            
            if ( $this->getNumberOfResults() == 1 && !preg_match(PT_CONTINUE, $this->raw)) {
                $data = $this->__buildFor1Row();
            } else {
                get_match_pattern(PT_MS_ROW, $this->raw, $matchRes);
                if ( empty($matchRes) || empty($matchRes[0]) ) {
                    return $data;
                }
                
                $cantFields = count($matchRes)-1;
                $cantRows = count($matchRes[0]);
                
                if ( $cantFields != count($this->msFields) ) {
                    throw new Exception('Deberian ser '.count($this->msFields).' columnas y este MS tiene '.$cantFields);
                }
                
                // construyo el array para modificando los indices
                // para agruparlos por registros
                
                for ($i = 0; $i < $cantFields; $i++) {
                    for ($j = 0; $j < $cantRows; $j++) {
                            $data[$j][ $this->msFields[$i] ] = trim($matchRes[$i+1][$j]);
                    }
                }
            }
        }
        $this->msLogTableData['LogMstation'] = $data;
        $this->__storeNewRecords();
    }
    
    
    /**
     * Guarda las FK de
     * Status
     * Mimo
     * FEC
     * 
     * 
     * @throws Exception
     */
    private function __storeNewRecords () {
        $aa = array(
            'mimo' => array(),
            'status' => array(),
            'fec' => array(),
        );
                
        foreach ($this->msLogTableData['LogMstation'] as $ms) {
            $aa['status'][] = $ms['status_id'];
            $aa['mimo'][] = $ms['mimo_id'];
            $aa['fec'][] = $ms['dl_fec_id'];
            $aa['fec'][] = $ms['ul_fec_id'];
        }
        
        
        $bb['status'] = array_unique($aa['status']);
        $bb['mimo'] = array_unique($aa['mimo']);
        $bb['fec'] = array_unique($aa['fec']);
        
        
        $status = ClassRegistry::init('Sky.Status');
        $status->recursive = -1;
        $mimo = ClassRegistry::init('Sky.Mimo');
        $mimo->recursive = -1;
        $fec = ClassRegistry::init('Sky.Fec');
        $fec->recursive = -1;
        
        foreach ( $bb['mimo'] as $m ) {
            $ss = $mimo->findById( $m );
            if ( !empty($m) && empty($ss) ) {
                $mimo->create();
                if ( !$mimo->save(array(
                    'Mimo' => array(
                        'id' => $m
                    )
                ))){
                    throw new Exception("No pudo guardar el Mimo Flag ".$m);
                }
            }
        }
        
        
        foreach ( $bb['status'] as $s ) {
            $ss = $status->findById( $s );
            if ( !empty($s) && empty($ss) ) {
                $status->create();
                if ( !$status->save(array(
                    'Status' => array(
                        'id' => $s
                    )
                ))) {
            throw new Exception("No pudo guardar el Estado $s");
                }
            }
        }
        
        foreach ( $bb['fec'] as $f ) {
            $ss = $fec->findById( $f );
            if ( !empty($f) && empty($ss) ) {
                $fec->create();
                if (!$fec->save(array(
                    'Fec' => array(
                        'id' => $f
                    )
                ))) {
                    throw new Exception("No pudo guardar el FEC $f");
                }
            }
         
        }
    }

    public function getDateTimeFromFilename () {
        $datetime = getDateTimeFromFilename($this->fileName);
        // coloca en cero los segundos
        $datetime = substr_replace($datetime, '00', strlen($datetime)-2, 2);
        return $datetime;
    }

    public function getSite () {
        return $this->msLogTableData['Site']['name'];
    }
    
    
    public function getSector () {
        return $this->msLogTableData['Sector']['name'];
    }
    
 
    public function getOm () {
        return $this->msLogTableData['MsLogTable']['om_id'];
    }
    
    
    public function getRetcodeCode () {
        return $this->msLogTableData['Retcode']['code'];
    }
    
    public function getRetcodeName () {
        return $this->msLogTableData['Retcode']['name'];
    }
    
    
    public function getComandNumber () {
        return $this->msLogTableData['MsLogTable']['comand_number'];
    }
    
    
    public function getCarrier () {
        return $this->msLogTableData['Carrier']['name'];
    }
    
    
    
    
    public function getNumberOfResults () {
      get_match_pattern(PT_NUMBER_RESULTS, $this->raw, $match);
      $this->results = 0;      
      foreach ( $match[1] as $m ) {
          $this->results += $m;
      }
      
      return  $this->results;
    }
           
}
