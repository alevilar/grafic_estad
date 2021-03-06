<?php


App::uses('FileParser', 'Sky.Lib');
App::uses('DataMigration', 'Sky.Lib');

class MigrateShell extends AppShell
{

    public $uses = array('Sky.MsLogTable');
    
    public $huboError = false;
    
    private $folderHistoricosName = '/historicos';


    /**
     *
     * @var array of DataMigration
     */
    public $aDataMig = array();
    
    
    public $cantMsGuardados = 0;
    

    /**
     *
     * @var FileParser
     */
    public $fp;
    
    
    public function startup () {
        parent::startup();
        
         $this->out("<warning>         ,==                 |)             O  O
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
        try {
            $tmpDir = Configure::read('Sky.tmpdir');
            if ( !file_exists($tmpDir) ) {
                if ( !mkdir($tmpDir) ) {
                    throw new Exception('No existe la carpeta temporal '.$tmpDir);
                }
            }
            if ( !file_exists($tmpDir.$this->folderHistoricosName) ) {
                if ( !mkdir($tmpDir.'/historicos') ) {
                    throw new Exception('No existe la carpeta de historicos '.$tmpDir.$this->folderHistoricosName);
                }
            }
            $this->fp = new FileParser( $tmpDir  );
        } catch (Exception $exc) {
            $this->out($exc->getMessage());
            $this->out("Falló al leer archivos");
            exit;
        }
        $this->out(" ");
        $this->out(" ");
        foreach ( $this->fp->files as $f ) {
            
            $this->out("  .--.      .-'.      .--.      .--.      .--.      .--.      .`-.      .--. ");
            $this->out(":::::.\::::::::.\::::::::.\::::::::.\::::::::.\::::::::.\::::::::.\::::::::.\ ");
            $this->out("'      `--'      `.-'      `--'      `--'      `--'      `-.'      `--'      ` ");
            
            $this->out("Leyendo archivo: ".$f->name);
            
            try {
                $this->fp->leerArchivo($f);
                
                  // contruir una Clase intermedia entre los datos del archivo y el Model de la BD
                  // Instancia un Objeto del tipo DataMigration
                  $this->_buildADataMig($f->name);

                  // guardar en la BD
                  $this->save_ADataMig();
            } catch (Exception $e) {
                $this->huboError = true;
                $this->out('Error al leer archivo ' . $f->name . ' (' .  $e->getMessage() . ')');
            }
            
            if ( !$this->huboError ) {
                // Mostrar un poco de información final
                $numberOfResults = $this->fp->getNumberOfResults();
                $this->out("Cantidad de MS según archivo: $numberOfResults y cantidad de MS guardados $this->cantMsGuardados");                        
            } else {
                $this->out('<error>Error al al procesar</error>');
            }
            
            // si paso todo bien elimino este archivo
            $f->copy($tmpDir.$this->folderHistoricosName."/".$f->name);
            $f->delete();
            
            // inicializo el error para la proxima vuelta
            $this->huboError = false;
        }

        // cerrar los archivos
        $this->fp->shutdown();
    }

    
    function _buildADataMig ($filename) {
        $this->aDataMig = array();
        
        foreach ( $this->fp->aContent as $ad ) {           
            $this->aDataMig[] = new DataMigration($filename,$ad);
        }
                
        return true;
    }
   

    
    function save_ADataMig()
    {
        $errores = $existente = $saved = $errorMs = $saveMs = 0;
        
        foreach ($this->aDataMig as  $as) {
            /* @var $as DataMigration */
            $this->out("Migrando SITIO ".$as->msLogTableData['Site']['name']." Sector ".$as->msLogTableData['Sector']['name']." y Carrier ".$as->msLogTableData['Carrier']['name']);

            // realiza algunas verficaciones y tira exception si encuentra algo mal
            $as->checkData();
            
            $as->limpiarMACDuplicadas();
                        
            $site_id = $this->_save_data_sitio($as);
            $sector_id = $this->_save_data_sector_de_sitio($as, $site_id);
            $carrier_id = $this->_save_data_carrier_de_sector($as, $sector_id);
            $retcode_id = $this->_save_data_retcode($as);
            
            $as->msLogTableData['MsLogTable']['site_id'] = $site_id;
            $as->msLogTableData['MsLogTable']['sector_id'] = $sector_id;
            $as->msLogTableData['MsLogTable']['carrier_id'] = $carrier_id;
            $as->msLogTableData['MsLogTable']['retcode_id'] = $retcode_id;

            if ( $as->msLogTableData['Retcode']['code'] != 0 ) {
                $this->out("el Retcode fue distinto de cero, omitiendo...");
                continue;
            }
                     
            $conds =  array(
                    'MsLogTable.site_id' => $site_id,
                    'MsLogTable.sector_id' => $sector_id,
                    'MsLogTable.carrier_id' => $carrier_id,
                    'MsLogTable.retcode_id' => $retcode_id,
                    'MsLogTable.datetime' => $as->msLogTableData['MsLogTable']['datetime'],
                    );  
            $exists = $this->MsLogTable->find('count', array(
                'conditions' =>  $conds,
                'recursive'  => -1,
                ));
            if ( !$exists ) {
                $this->out("        Creando nuevo registro de Ms Table");
                $as->calcularYCompletarTotales();
                $this->MsLogTable->create();
                if ($this->MsLogTable->save($as->msLogTableData)) {
                    $saved++;    
                    
                    $msData = array();
                    foreach ( $as->msLogTableData['LogMstation'] as $ls  ) {
                        $ls['ms_log_table_id'] = $this->MsLogTable->id;
                        $msData[]['LogMstation'] = $ls;
                    }
                    
                    if ( !($this->MsLogTable->LogMstation->saveAll($msData)) ) {
                        $this->huboError = true;
                        $errorMs++;
                        $this->err($this->MsLogTable->LogMstation->validationErrors);
                        continue;
                    } else {                            
                        $saveMs++;
                    }
                    $this->out("        Se procesaron ".count($as->msLogTableData['LogMstation'])." Stations");
                } else {
                    $this->huboError = true;
                    $this->err($this->MsLogTable->validationErrors);
                    $errores++;
                    continue;
                }
            } else {
                $this->out('        Este dato ya existia. Omitiendo. '.$as->msLogTableData['MsLogTable']['datetime']);
                $existente++;
            }
            
            
        }
        
        if ($errores) {
            $this->out("         <error>Hubo $errores errores al guardar la tabla de datos</error>");
        }
        
        if ($existente) {
            $this->out("         <warning>$existente registros ya existian en la BD y no han sido guardados</warning>");
        }
        
        if ($saved) {
            $this->out("        <success>$saved registros nuevos guardados con $saveMs MS nuevas</success>");
        }
        
        if ($errorMs) {
            $this->out("        <error>$errorMs errores en ms</error>");
        }
        
        
    }

    /**
     * Devuelve el id del sitio que viene por nombre
     * Si el sitio no está previamente guardado se lo crea.
     * 
     * @param DataMigration $aDataMig
     * @return int sitio id
     * @throws Exception
     */
    function _save_data_sitio($aDataMig)
    {
        $sitio_id = null;
        $sitioName = $aDataMig->getSite();        
        if ( $sitioName ) {
            $this->MsLogTable->Site->recursive = -1;
            $sitio = $this->MsLogTable->Site->findByName($sitioName);
            if ( !$sitio ) {
                $this->MsLogTable->Site->create();
                if (!$this->MsLogTable->Site->save(array('Site' => array('name' => $sitioName)))) {
                    throw new Exception("No puedo guardar el sitio con nombre; " . $sitioName);
                }
                $sitio_id = $this->MsLogTable->Site->id;
            } else {
                $sitio_id = $sitio['Site']['id'];
            }
            return $sitio_id;
        }
        return $sitio_id;
    }
    
    function _save_data_retcode ($aDataMig){
        $ret_id = null;
        $retcodeId = $aDataMig->getRetcodeCode();
        $retcodeName = $aDataMig->getRetcodeName();
        if ( $retcodeName && is_numeric($retcodeId)) {
            $this->MsLogTable->Retcode->recursive = -1;
            $data = $this->MsLogTable->Retcode->findByCode($retcodeId);
            if ( !$data ) {
                $sv = array(
                        'Retcode' => array(
                            'name' => $retcodeName,
                            'code' => $retcodeId,
                                )
                );
                $this->MsLogTable->Retcode->create();
                if (!$this->MsLogTable->Retcode->save($sv)) {
                    throw new Exception("No puedo guardar el retcode con id $retcodeId y nombre; " . $retcodeName);
                }
                $ret_id = $this->MsLogTable->Retcode->id;
            } else {
                $ret_id = $data['Retcode']['id'];
            }
        }
        return $ret_id;
    }
    
    
    function _save_data_carrier_de_sector ($aDataMig, $sector_id) {
        $carrierName = $aDataMig->getCarrier();
        $ret_id = null;
        if ( is_numeric($carrierName) ) {
            $this->MsLogTable->Site->Sector->Carrier->recursive = -1;
            $data = $this->MsLogTable->Site->Sector->Carrier->findByNameAndSectorId($carrierName,$sector_id);
            if (!$data) {
                $this->MsLogTable->Site->Sector->Carrier->create();
                if ( !$this->MsLogTable->Site->Sector->Carrier->save(array(
                    'Carrier' => array(
                        'sector_id' => $sector_id,
                        'name' => $carrierName
                            )
                    ))) {
                    throw new Exception("No puedo guardar el carrier con nombre: " . $carrierName);
                }
                $ret_id = $this->MsLogTable->Site->Sector->Carrier->id;
            } else {
                $ret_id = $data['Carrier']['id'];
            }
        }
        return $ret_id;
    }
    
    function _save_data_sector_de_sitio($aDataMig, $sitio_id)
    {
        $sector_id = null;
        $sectorName = $aDataMig->getSector();
        if ( is_numeric($sectorName) ) {
            $this->MsLogTable->Site->Sector->recursive = -1;
            $sector = $this->MsLogTable->Site->Sector->findByNameAndSiteId($sectorName,$sitio_id);
            if (!$sector) {
                $this->MsLogTable->Site->Sector->create();
                if (!$this->MsLogTable->Site->Sector->save(array(
                    'Sector' => array(
                        'site_id' => $sitio_id,
                        'name' => $sectorName
                            )
                    ))) {
                    throw new Exception("No puedo guardar el sector con nombre; " . $sectorName);
                }
                $sector_id = $this->MsLogTable->Site->Sector->id;
            } else {
                $sector_id = $sector['Sector']['id'];
            }
        }
        return $sector_id;
    }

    

}