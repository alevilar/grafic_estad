<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


define('PT_SITE', '/\[Ne Name\].*\n*\s*([a-zA-Z0-9]+.*[a-zA-Z0-9]*)/');
define('PT_SECTOR', '/%%\/\*[0-9]*\*\/DSP ALLMSINFO:SECTORID=(\d+),CARRIERID=\d+;%%/');
define('PT_CARRIER', '/%%\/\*[0-9]*\*\/DSP ALLMSINFO:SECTORID=\d+,CARRIERID=(\d+);%%/');


define('PT_TAG_REPORT', '/\[Mml Command Report\]/');

define('PT_INICIO', '/\[Ne Name\]/');
define('PT_FECHA', '/\+\+\+.*(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/');
define('PT_OM', '/O&M....#(\d+)/');
define('PT_COMANDO_ID', '/%%.\*(\d+)\*.DSP ALLMSINFO:SECTORID=\d+,CARRIERID=\d+;%%/');

define('PT_RETCODE_ID', '/\[Mml Command retCode\].*\n*\s*(-?\d*)/');
define('PT_RETCODE', '/\[Mml Command Result\].*\n*\s*([a-zA-Z0-9]+.*[a-zA-Z0-9]*)/');

define('PT_TABLE_HEADER', '/Sector ID\s+Carrier +ID\s+MSID\s+MSSTATUS\s+MSPWR\(dBm\)\s+DLCINR\(dB\)\s+ULCINR\(dB\)\s+DLRSSI\(dBm\)\s+ULRSSI\(dBm\)\s+DLFEC\s+ULFEC\s+DLREPETITIONFATCTOR\s+ULREPETITIONFATCTOR\s+DLMIMOFLAG\s+BENUM\s+NRTPSNUM\s+RTPSNUM\s+ERTPSNUM\s+UGSNUM\s+UL PER for an MS.*NI Value of the Band Where an MS Is Located.*\s+DL Traffic Rate for an MS\(byte.s\)\s+UL Traffic Rate for an MS\(byte.s\)/');
define('PT_MS_ROW', '/(-?\d)\s*(-?\d)\s*(....-....-......)\s*([a-zA-Z0-9]*)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s+([a-zA-Z0-9]+ ? ?[a-zA-Z_]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)\s*(-?[0-9]+)/');

define('PT_MS_SECTOR_ID', '/\s*Sector ID  =  /');
define('PT_MS_CARRIER_ID', '/\s*Carrier ID  =  /');
define('PT_MS_MSID', '/\s*MSID  =  /');
define('PT_MS_STATUS', '/\s*MSSTATUS  =  /');
define('PT_MS_PWR', '/\s*MSPWR\(dBm\)  =  /');
define('PT_MS_DLCINR', '/\s*DLCINR\(dB\)  =  /');
define('PT_MS_ULCINR', '/\s*ULCINR\(dB\)  =  /');
define('PT_MS_DLRSSI', '/\s*DLRSSI\(dBm\)  =  /');
define('PT_MS_ULRSSI', '/\s*ULRSSI\(dBm\)  =  /');
define('PT_MS_DLFEC', '/\s*DLFEC  =  /');
define('PT_MS_ULFEC', '/\s*ULFEC  =  /');
define('PT_MS_DLREPETITIONFATCTOR', '/\s*DLREPETITIONFATCTOR  =  /');
define('PT_MS_ULREPETITIONFATCTOR', '/\s*ULREPETITIONFATCTOR  =  /');
define('PT_MS_DLMIMOFLAG', '/\s*DLMIMOFLAG  =  /');
define('PT_MS_BENUM', '/\s*BENUM  =  /');
define('PT_MS_NRTPSNUM', '/\s*NRTPSNUM  =  /');
define('PT_MS_RTPSNUM', '/\s*RTPSNUM  =  /');
define('PT_MS_ERTPSNUM', '/\s*ERTPSNUM  =  /');
define('PT_MS_UGSNUM', '/\s*UGSNUM  =  /');
define('PT_MS_ULPER', '/\s*UL PER for an MS\(0\.001\)  =  /');
define('PT_MS_NIVALUE', '/NI Value of the Band Where an MS Is Located\(dBm\)  =  /');
define('PT_MS_DLTRAFFICRATE', '/\s*DL Traffic Rate for an MS\(byte.s\)  =  /');
define('PT_MS_ULTRAFFICRATE', '/\s*UL Traffic Rate for an MS\(byte.s\)  =  /');


define('PT_REPORTS', '/(\d+) reports in total/');
define('PT_END', '/---    END/');
define('PT_CONTINUE', '/To be continued.../');

define('PT_NUMBER_RESULTS', '/\(Number of results = (\d+)\)/'); // menos la que da 1 solo resultado
//define('PT_NUMBER_RESULTS_1ROW', '/\(Number of results = 1\)/'); // la que da solo 1 resultado


define('PT_FILENAME_DATE', '/(\d{4}-\d{2}-\d{2})/');
define('PT_FILENAME_TIME', '/[^\d](\d{2}-\d{2}-\d{2})/');


define('SK_EXPLODE_PATTERN',"/\[Ne Name\]/");


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
    
    
    /**
     * Completa la variable $this->aContent
     * con el archivo desmenusado por SITIO
     * 
     * @param File $f
     * @throws Exception
     */
    public function leerArchivo ( $f ) {
        $this->reset();
        $content = '';
        
        $nContent = $f->read();
        if (!$nContent) {
            throw new Exception("Could not read this file: $f->name");
        }
        $content .= $nContent;

        // separo el archivo por sitio
        $vv = preg_match_all(SK_EXPLODE_PATTERN, $content, $mach, PREG_OFFSET_CAPTURE);
        
        $cont = array();
        foreach ($mach[0] as $k=>$v) {          
            if ( $k+1 < count($mach[0]) ) {
                $cont[] = substr($content, $mach[0][$k][1], $mach[0][$k+1][1]-$mach[0][$k][1]);
            } else {
                // es el ultimo dato, entonces leo hasta el final
                $cont[] = substr($content, $mach[0][$k][1]);
            }
        }
        
        // archivo desmenusado por SITIO
        $this->aContent = $cont;
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
        foreach ( $this->aContent as $c ) {
            $this->numberOfResults += get_num_results_value($c);
        }
        return $this->numberOfResults;
    }
    

}
