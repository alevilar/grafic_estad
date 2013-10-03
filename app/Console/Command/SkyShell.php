<?php

define('SK_INICIO_1_ROW', 'inicio_1_row');
define('SK_INICIO', 'inicio');
define('SK_FECHA', 'fecha');
define('SK_OM', 'om');
define('SK_COMANDO_ID', 'comando_id');
define('SK_RETCODE', 'retcode');
define('SK_TABLE_HEADER', 'table_header');
define('SK_MS_ROW', 'ms_row');
define('SK_TABLE_END', 'table_end');
define('SK_CONTINUE', 'continue');
define('SK_END', 'end');
define('SK_SECTOR_ID', 'sector_id');
define('SK_CURR_LINE_END', 'currLine_end');






App::uses('FileParser', 'Lib');

class SkyShell extends AppShell {
    
    public $uses = array('Sky.MsLogTable');
    
    
    /**
     *
     * @var FileParser
     */
    public $fp;
    
    static $checkOrder = array(
         SK_INICIO => array( SK_FECHA ),
         SK_FECHA => array( SK_OM ),
         SK_OM => array( SK_COMANDO_ID ),
         SK_COMANDO_ID => array( SK_RETCODE ),
         SK_RETCODE => array( SK_TABLE_HEADER, SK_SECTOR_ID, SK_END ),
         SK_TABLE_HEADER => array( SK_MS_ROW ),
         SK_MS_ROW => array( SK_MS_ROW, SK_TABLE_END ),
         SK_TABLE_END => array( SK_CONTINUE, SK_END ),
         SK_CONTINUE => array( SK_END ),
         SK_END => array( SK_INICIO, SK_INICIO_1_ROW, SK_FECHA, SK_CURR_LINE_END),    
        
         SK_INICIO_1_ROW => array( SK_FECHA ),
         SK_SECTOR_ID =>  array( SK_TABLE_END ),
        
         SK_CURR_LINE_END => array(),
     );
    
     public function __construct($stdout = null, $stderr = null, $stdin = null)
     {
         parent::__construct($stdout, $stderr, $stdin);
         
         $this->fp = new FileParser(Configure::read('Sky.tmpdir'));
     }


     public function main() {
        
        if (empty($this->fp->aContent)) {
            $this->out("<error>Empty File $this->fp->name</error>");
            exit;
        }
       
        $this->_verificar_archivo();
        
        $archSeparado = $this->_separar_archivo();
        
        
        foreach ($archSeparado as $as ) {
            $sitioName = $this->getSitioName($as);
            $this->out($sitioName);
        }
        
        
        $this->fp->shutdown();
    }
        
    /**
     * 
     * @return Array de la siguiente forma:
            (int) 0 => array(
                'inicio' => (int) 0,
                'fecha' => (int) 2,
                'om' => (int) 3,
                'comando_id' => (int) 4,
                'retcode' => (int) 5,
                'table_header' => (int) 9,
                'ms_row' => array(
                        (int) 0 => (int) 11,
                        (int) 1 => (int) 12,
                        (int) 2 => (int) 13,
                        (int) 3 => (int) 14,
                        (int) 4 => (int) 15,
                        (int) 5 => (int) 16,
                        (int) 6 => (int) 17,
                        (int) 7 => (int) 18,
                        (int) 8 => (int) 19,
                        (int) 9 => (int) 20,
                        (int) 10 => (int) 21
                ),
                'table_end' => (int) 22,
                'end' => (int) 25
     * 
     */
    function _separar_archivo () {
        $continue = false;
        $ms_row = false;
        $lineAnterior = SK_END;
        $j = 0;
        $i = 0;
        $this->fp->reset();
        
        
        /**
         * 

         */
        $aData = array();
        
        do {
            // verificar orden que este correcto y no haya inconsistencias
            $line = $this->fp->detectLine($j);
            if ( !empty($line)) {
                
                if ( $line == SK_CURR_LINE_END ) {
                    // fin de todo, termino de leer el archivo
                    break;
                }
                

                if ( $line != SK_MS_ROW ) {
                    $aData[$i][$line] = $this->fp->currLine;                    
                } else {
                    $aData[$i][$line][] = $this->fp->currLine;
                }

                if ( $line == SK_END && !$continue) {
                    // si no continua incrementar el array
                    $i++;
                }
                
                if ( $continue ) {
                    // resetear el continue
                    $continue = false; 
                }

                if ( $line == SK_CONTINUE ) {
                    // settar que continua y el siguiente loop es el mismo key del array
                    $continue = true;
                }
            }
            
            $j++;
        } while ( $this->fp->nextLine() > -1 );
        return $aData;
    }
    
    function _verificar_archivo () {        
        $lineAnterior = SK_END;
        $i = 0;
        $this->fp->reset();
        do {
            // verificar orden que este correcto y no haya inconsistencias
            $line = $this->fp->detectLine($i);
            
            if ( !empty($line) ) {
                if ( !$this->_check_from_to($lineAnterior, $line) ) {
                    $this->out( "<error>(Line: ".$this->fp->currLine.") no corresponden al orden correcto $lineAnterior -- $line</error>");
                } else {
                    $lineAnterior = $line;
                }
            }
            $i++;
        } while ( $this->fp->nextLine() > -1 );
        $this->out( "El archivo esta bien formado, procesando datos...");
    }
    
    function _check_from_to($from, $to) {
        return in_array($to, SkyShell::$checkOrder[$from]);
    }
    
    
    
    function getSitioName ($aData) {
        $line = -1;
        if ( array_key_exists(SK_INICIO, $aData) ) {
           $line =  $aData[SK_INICIO];
        } elseif ( array_key_exists(SK_INICIO_1_ROW, $aData) ) {
           $line =  $aData[SK_INICIO_1_ROW];
        } else {
            return '';
        }
        if ( $line > -1 ) {
            $dataLine = $this->fp->readLine( $line+1 );
        } else {
            throw new Exception('No pudo saber que linea leer en getSitioName()');
        }
        
        return trim($dataLine);
    }
}