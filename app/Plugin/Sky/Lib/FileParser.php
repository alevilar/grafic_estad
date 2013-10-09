<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


define('PT_INICIO', '/\[Ne Name\]/');
define('PT_FECHA', '/\+\+\+.*(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/');
define('PT_OM', '/O&M....#(\d+)/');
define('PT_COMANDO_ID', '/%%.\*(\d+)\*.DSP ALLMSINFO:SECTORID=(\d+),CARRIERID=(\d+);%%/');
define('PT_RETCODE', '/RETCODE = (\d+)..([a-zA-Z ]*)/');
define('PT_TABLE_HEADER', '/Sector ID\s+Carrier +ID\s+MSID\s+MSSTATUS\s+MSPWR\(dBm\)\s+DLCINR\(dB\)\s+ULCINR\(dB\)\s+DLRSSI\(dBm\)\s+ULRSSI\(dBm\)\s+DLFEC\s+ULFEC\s+DLREPETITIONFATCTOR\s+ULREPETITIONFATCTOR\s+DLMIMOFLAG\s+BENUM\s+NRTPSNUM\s+RTPSNUM\s+ERTPSNUM\s+UGSNUM\s+UL PER for an MS.*NI Value of the Band Where an MS Is Located.*\s+DL Traffic Rate for an MS\(byte.s\)\s+UL Traffic Rate for an MS\(byte.s\)/');
define('PT_MS_ROW', '/\d *\d *....-....-......*MIMO . *[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]* + *-?[0-9]*  */');

define('PT_MS_SECTOR_ID', '/                                       Sector ID  =  /');
define('PT_MS_CARRIER_ID', '/                                      Carrier ID  =  /');
define('PT_MS_MSID', '/                                            MSID  =  /');
define('PT_MS_STATUS', '/                                        MSSTATUS  =  /');
define('PT_MS_PWR', '/                                      MSPWR\(dBm\)  =  /');
define('PT_MS_DLCINR', '/                                      DLCINR\(dB\)  =  /');
define('PT_MS_ULCINR', '/                                      ULCINR\(dB\)  =  /');
define('PT_MS_DLRSSI', '/                                     DLRSSI\(dBm\)  =  /');
define('PT_MS_ULRSSI', '/                                     ULRSSI\(dBm\)  =  /');
define('PT_MS_DLFEC', '/                                           DLFEC  =  /');
define('PT_MS_ULFEC', '/                                           ULFEC  =  /');
define('PT_MS_DLREPETITIONFATCTOR', '/                             DLREPETITIONFATCTOR  =  /');
define('PT_MS_ULREPETITIONFATCTOR', '/                             ULREPETITIONFATCTOR  =  /');
define('PT_MS_DLMIMOFLAG', '/                                      DLMIMOFLAG  =  /');
define('PT_MS_BENUM', '/                                           BENUM  =  /');
define('PT_MS_NRTPSNUM', '/                                        NRTPSNUM  =  /');
define('PT_MS_RTPSNUM', '/                                         RTPSNUM  =  /');
define('PT_MS_ERTPSNUM', '/                                        ERTPSNUM  =  /');
define('PT_MS_UGSNUM', '/                                          UGSNUM  =  /');
define('PT_MS_ULPER', '/                         UL PER for an MS\(0\.001\)  =  /');
define('PT_MS_NIVALUE', '/NI Value of the Band Where an MS Is Located\(dBm\)  =  /');
define('PT_MS_DLTRAFFICRATE', '/               DL Traffic Rate for an MS\(byte.s\)  =  /');
define('PT_MS_ULTRAFFICRATE', '/               UL Traffic Rate for an MS\(byte.s\)  =  /');


define('PT_REPORTS', '/(\d+) reports in total/');
define('PT_END', '/---    END/');
define('PT_CONTINUE', '/To be continued.../');

define('PT_NUMBER_RESULTS', '/\(Number of results = (\d+)\)/'); // menos la que da 1 solo resultado
//define('PT_NUMBER_RESULTS_1ROW', '/\(Number of results = 1\)/'); // la que da solo 1 resultado



define('SK_EXPLODE_PATTERN',"\n");


class FileParser
{

    /**
     * @var Folder
     */
    public $folder;

    /**
     * @var array of File 
     */
    public $files = array();
    
    
    public $aContent = array();
    public $numberOfResults = 0;
    public $errorsMsg = '';
    
    /**
     * Este array es el que mantiene los estados DESDE -> HASTA válidos
     * se usan para verificar el estado del archivo a migrar
     * 
     * @var array
     */
    static $checkOrder = array(
        SK_INICIO => array(SK_SITENAME),
        SK_SITENAME => array(SK_FECHA, SK_INICIO),
        SK_FECHA => array(SK_OM),
        SK_OM => array(SK_COMANDO_ID),
        SK_COMANDO_ID => array(SK_RETCODE),
        SK_RETCODE => array(SK_TABLE_HEADER, SK_SECTOR_ID, SK_END),
        SK_TABLE_HEADER => array(SK_MS_ROW),
        SK_MS_ROW => array(SK_MS_ROW, SK_NUMBER_RESULTS),
        SK_NUMBER_RESULTS => array(SK_CONTINUE, SK_REPORTS, SK_END),
        SK_REPORTS =>  array(SK_END),
        SK_CONTINUE => array(SK_END),
        SK_END => array(SK_INICIO, SK_INICIO_1_ROW, SK_FECHA, SK_CURR_LINE_END),
        
        
        SK_SITENAME => array(SK_FECHA),
        SK_SECTOR_ID => array( SK_MS_CARRIER_ID ),
        SK_CURR_LINE_END => array(),
        
        SK_MS_CARRIER_ID => array(SK_MS_MSID),
        SK_MS_MSID => array(SK_MS_STATUS),
        SK_MS_STATUS => array(SK_MS_PWR),
        SK_MS_PWR => array(SK_MS_DLCINR),
        SK_MS_DLCINR => array( SK_MS_ULCINR),
        SK_MS_ULCINR => array(SK_MS_DLRSSI),
        SK_MS_DLRSSI => array(SK_MS_ULRSSI),
        SK_MS_ULRSSI => array(SK_MS_DLFEC),
        SK_MS_DLFEC => array(SK_MS_ULFEC),
        SK_MS_ULFEC => array(SK_MS_DLREPETITIONFATCTOR),
        SK_MS_DLREPETITIONFATCTOR => array(SK_MS_ULREPETITIONFATCTOR),
        SK_MS_ULREPETITIONFATCTOR => array(SK_MS_DLMIMOFLAG),
        SK_MS_DLMIMOFLAG => array(SK_MS_BENUM),
        SK_MS_BENUM => array(SK_MS_NRTPSNUM),
        SK_MS_NRTPSNUM => array(SK_MS_RTPSNUM),
        SK_MS_RTPSNUM => array(SK_MS_ERTPSNUM),
        SK_MS_ERTPSNUM => array(SK_MS_UGSNUM),
        SK_MS_UGSNUM => array(SK_MS_ULPER),
        SK_MS_ULPER => array(SK_MS_NIVALUE),
        SK_MS_NIVALUE => array(SK_MS_DLTRAFFICRATE),
        SK_MS_DLTRAFFICRATE => array(SK_MS_ULTRAFFICRATE),
        SK_MS_ULTRAFFICRATE => array(SK_NUMBER_RESULTS),
            
    );

    
    
    /**
     * Este se usa para detectar que es la linea
     * Hace un macheo entre el pattern PT_ y la identificación del tipo de dato SK_
     * 
     * Detecta el pattern (KEY) EJ: PT_INICIO
     * 
     * y devuelve el value del array indicando el tipo de dato, Ej: SK_INICIO
     * 
     * @var array
     */
    private $automaticPattern = array(
        PT_INICIO => SK_INICIO,
        PT_FECHA => SK_FECHA,
        PT_OM => SK_OM,
        PT_COMANDO_ID => SK_COMANDO_ID,
        PT_RETCODE => SK_RETCODE,
        PT_TABLE_HEADER => SK_TABLE_HEADER,
        PT_END => SK_END,
        PT_CONTINUE => SK_CONTINUE,
        PT_NUMBER_RESULTS => SK_NUMBER_RESULTS,
//        PT_NUMBER_RESULTS_1ROW => SK_NUMBER_RESULTS_1ROW,
        
        PT_REPORTS => SK_REPORTS,
        
        PT_MS_ROW => SK_MS_ROW,
        PT_MS_SECTOR_ID => SK_SECTOR_ID,
        PT_MS_CARRIER_ID => SK_MS_CARRIER_ID,
        PT_MS_MSID => SK_MS_MSID,
        PT_MS_STATUS => SK_MS_STATUS,
        PT_MS_PWR => SK_MS_PWR,
        PT_MS_DLCINR => SK_MS_DLCINR,
        PT_MS_ULCINR => SK_MS_ULCINR,
        PT_MS_DLRSSI => SK_MS_DLRSSI,
        PT_MS_ULRSSI => SK_MS_ULRSSI,
        PT_MS_DLFEC => SK_MS_DLFEC,
        PT_MS_ULFEC => SK_MS_ULFEC,
        PT_MS_DLREPETITIONFATCTOR => SK_MS_DLREPETITIONFATCTOR,
        PT_MS_ULREPETITIONFATCTOR => SK_MS_ULREPETITIONFATCTOR,
        PT_MS_DLMIMOFLAG => SK_MS_DLMIMOFLAG,
        PT_MS_BENUM => SK_MS_BENUM,
        PT_MS_NRTPSNUM => SK_MS_NRTPSNUM,
        PT_MS_RTPSNUM => SK_MS_RTPSNUM,
        PT_MS_ERTPSNUM => SK_MS_ERTPSNUM,
        PT_MS_UGSNUM => SK_MS_UGSNUM,
        PT_MS_ULPER => SK_MS_ULPER,
        PT_MS_NIVALUE => SK_MS_NIVALUE,
        PT_MS_DLTRAFFICRATE => SK_MS_DLTRAFFICRATE,
        PT_MS_ULTRAFFICRATE => SK_MS_ULTRAFFICRATE,
    );

    public function __construct($tmpPathFolder)
    {
        // leer carpeta
        $this->folder = new Folder($tmpPathFolder);
        $readfolder = $this->folder->read( true );

        // recorrer todos los archivos de la carpeta y colocarlos en $this->files
        foreach ($readfolder[1] as $file) {            
            $ff = new File($this->folder->pwd() . DS . $file);
            $this->files[] = $ff;
        }

    }
    
    
    public function leerArchivo ( $f ) {
        $this->reset();
        $content = '';
        
        $nContent = $f->read();
        if (!$nContent) {
            throw new Exception("Could not read this file: $f->name");
        }
        $content .= $nContent;
        
        $this->aContent = explode(SK_EXPLODE_PATTERN, $content);
        
        // verifico consistencia de los comandos del archivo
//        if ( !$this->verificar_aContent() ) {
//            throw new Exception('Error al verificar el archivo: '.$this->errorsMsg);
//        }
    }

    function reset()
    {
        $this->numberOfResults = 0;
        $this->aContent = '';
        $this->numberOfResults = 0;
        $this->errorsMsg = '';
    }

    function shutdown()
    {
        foreach ($this->files as $file) {
            $file->close(); // Be sure to close the file when you're done
        }
    }
   

    
    public function getNumberOfResults () {
        $this->numberOfResults = 0;
        foreach ( $this->aContent as $k=>$c ) {
            if ( $this->detectLine( $k ) == SK_NUMBER_RESULTS ) {
                $this->numberOfResults += get_num_results_value($c);
            }
        }
        return $this->numberOfResults;
           
    }
    
    
    public function detectLine( $line )
    {
        if ($line >= count($this->aContent)) {
            // se alcanzó el fin del array
            return SK_CURR_LINE_END;
        }

        // Truquito para agarrar el nombre del sitio 
        // que esta justo abajo del inicio
        if ( $line - 1 >= 0 ) {
            // Inicio de comando
            $pattern = PT_INICIO;
            if ( $this->__search_pattern($pattern, $line - 1) ) {
                return SK_SITENAME;
            }
        }

        // procesar el resto de los comandos automaticos
        foreach ($this->automaticPattern as $pattern => $sk_ret_val) {
            if ($this->__search_pattern($pattern, $line)) {
                return $sk_ret_val;
            }
        }
    }



    /**
     * Search in current line or in key_line given as param
     * 
     * @param Regex $pattern
     * @param Int $key_line Linea del array aContent
     * @return Boolean if founded
     * 
     */
    private function __search_pattern($pattern, $key_line)
    {
        $cant = count($this->aContent);
        if ($key_line > -1 && $key_line < count($this->aContent)) {
            return preg_match($pattern, $this->aContent[$key_line]);
        }
        return false;
    }

    
    
    
     
    /**
     * Separa el archivo cada carrier por separado
     * 
     * @return array
     */
    public function separar_archivo ()
    {
        $continue = false;
        $ms_row = false;
        $lineAnterior = SK_END;
        $i = 0;

        $aData = array();
        foreach ( $this->aContent as $j=>$rawLine ) {
            // me devuelve el tipo de linea
            $lineType = $this->detectLine( $j );
            if (!empty($lineType)) {

                if ($lineType == SK_CURR_LINE_END) {
                    // fin de todo, termino de leer el archivo
                    break;
                }

                if ($lineType == SK_MS_ROW) {
                    // es MStation
                    $aData[$i][$lineType][] = $rawLine;
                } elseif ( $lineType == SK_NUMBER_RESULTS ) {
                    // es el indicador de MS rows que hay EJ: (Number of results = 50)
                    $aData[$i][SK_NUMBER_RESULTS][] = $rawLine;
                } else {
                    // esa dato de la tabla
                    $aData[$i][$lineType] = $rawLine;
                    
                }
                
                if ( $lineType == SK_END ) {
                    if ( $continue ) {
                        // reinicializar $continue sin incrementar contador
                        $continue = false;
                    } else {
                        // si no continua incrementar contador
                        $i++;
                    }
                }                

                if ( $lineType == SK_CONTINUE ) {
                    // settar que continua y el siguiente loop es el mismo key del array
                    $continue = true;
                }
            }
        }
        
        return $aData;
    }
    
    
    
    /**
     * Indica si el archivo sigue el orden de lineas esperado
     * 
     * @return boolean true si está bien formado
     */
    public function verificar_aContent ()
    {
        $error = false;
        $lineAnterior = SK_END;
        $lineAnteriorNumber = 0;
        foreach ( $this->aContent as $i=>$linea ) {
            $line = $this->detectLine($i);
            if (!empty($line)) {
                if (!$this->_check_from_to($lineAnterior, $line)) {
                    $error = true;
                    $this->errorsMsg = "Se quiso pasar de $lineAnterior ($lineAnteriorNumber) a $line ($i). Y está mal";
                    return false;
                }
                
                $lineAnterior = $line;
                $lineAnteriorNumber = $i;
            }
        }    
        return !$error;
    }
    
    
    private function _check_from_to($from, $to)
    {
        return in_array($to, FileParser::$checkOrder[$from]);
    }

}
