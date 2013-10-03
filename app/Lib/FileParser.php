<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');



class FileParser {
    
    /**
      * @var Folder
      */
     public $folder;
     
     /**
      * @var array of File 
      */
     public $files = array();
     
     public $currLine = 0;
     
     public $aContent = array();
     
     
     


     public function __construct( $tmpPathFolder )
    {
        $this->folder = new Folder( $tmpPathFolder );
        $readfolder = $this->folder->read();  
        
        foreach ($readfolder[1] as $file) {
             $ff = new File($this->folder->pwd() . DS . $file);
             $this->files[] = $ff;
        }
        
        $this->_leer_archivos();
    }
    
    
    function reset() {
        $this->currLine = 0;
    }
    
    
    function shutdown () {
        foreach ( $this->files as $file ) {
            $file->close(); // Be sure to close the file when you're done
        }
    }
       
    
    function _leer_archivos () {        
        $content = '';
        foreach ($this->files as $f) {
            $nContent = $f->read();
            if ( !$nContent ) {
                throw new Exception("Could not read this file: $f->name");
            }
            $content .= $nContent;
        }        
        $this->aContent = explode("\n", $content);
    }
    
    
    function nextLine () {
        if ( $this->currLine < count( $this->aContent ) ) {
            $this->currLine = $this->currLine+1;
            return $this->currLine;
        } else {
            return -1;
        }
    }
    
    
    
    
    function readLine( $line = null){
        if ($line === null) {
            $line = $this->currLine;
        }
        return $this->aContent[$line];
    }
    
    
    function detectLine ( $line = null ) {
        if ( $line !== null ) {            
            $this->currLine = $line;
        }
        if ( $this->currLine >= count( $this->aContent ) ) {
            return SK_CURR_LINE_END;
        }
            
        // Inicio de comando
        $pattern = '/^DSP ALLMSINFO:*/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            $pattern = '/^\(Number of results = 1\)$/';
            if ( $this->__search_pattern($pattern, $this->currLine+32) ) {
               return SK_INICIO_1_ROW;
            } else {
               return SK_INICIO;
            }
        }
        
        // linea de fecha
        $pattern = '/^\+\+\+    ..............\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_FECHA;
        }
        
        // Codigo O&M
        $pattern = '/^O&M....#\d+/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_OM;
        }
        
        // Numero de comando
        $pattern = '/^%%.\*\d+\*.DSP ALLMSINFO:SECTORID=\d+,CARRIERID=\d+;%%/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_COMANDO_ID;
        }
        
        // RETCODE
        $pattern = '/^RETCODE = \d+..[a-zA-Z ]*/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_RETCODE;
        }
        
        
        $pattern = '/Sector +ID +Carrier +ID +MSID +MSSTATUS +MSPWR\(dBm\) +DLCINR\(dB\) +ULCINR\(dB\) +DLRSSI\(dBm\) +ULRSSI\(dBm\) +DLFEC *ULFEC +DLREPETITIONFATCTOR +ULREPETITIONFATCTOR +DLMIMOFLAG +BENUM +NRTPSNUM +RTPSNUM +ERTPSNUM +UGSNUM +UL PER for an MS\(0\.001\) +NI Value of the Band Where an MS Is Located\(dBm\) +DL Traffic Rate for an MS\(byte.s\) +UL Traffic Rate for an MS\(byte.s\)/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_TABLE_HEADER;
        }

        $pattern = '/\d *\d *....-....-......*MIMO . *[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]+ *-?[0-9]* + *-?[0-9]*  */';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_MS_ROW;
        }
        
        
        
        
        $pattern = '/^                                       Sector ID  =  /';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_SECTOR_ID;
        }
        
        $pattern = '/^\(Number of results = \d+\)/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_TABLE_END;
        }
        
        $pattern = '/^---    END$/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_END;
        }
        
        
        $pattern = '/^To be continued...$/';
        if ( $this->__search_pattern($pattern, $this->currLine) ) {
            return SK_CONTINUE;
        }
        
        
    }
        
    
    function _sig_linea_inicio_de_comando () {
        $pattern = '/^DSP ALLMSINFO:*/';        
        return $this->__search_next_pattern($pattern, 0);
    }
            
    
    /**
     * Indica si para la linea actual es el fin del comando
     * 
     * @return int
     *              1 si terminó el comando "---END"
     *             -1 si terminó pero continua "to be continued..."
     *              0 Si no es Fin
     * @throws NotFoundException
     */
    function _currLine_es_fin () {
        $pattern = '/^---    END$/';
        $line = $this->__search_pattern($pattern, $this->currLine);
        
        // No Encontró ---END
        if (!$line) {
            return 0;
        }
        
        $continua = false;
        if ( preg_match( 'To be continued...', $this->aContent[$line-2] ) ) {
            $continua = true;
        }
        
        // Encontró ---END y no continua
        if ($line && !$continua) {
            return -1;
        }
        
        
        // Encontró ---END y no continua
        if ($line && $continua) {
            return 1;
        }
        
    }
    
    
    function _leer_y_seguir( $pattern , $fromLine = null ) {
        if ( $fromLine === null ) {
            $fromLine = $this->currLine;
        }
        $findLine = $this->__search_pattern($pattern, $fromLine);
        if ( $findLine >= 0 ) {
            $curLine = $fromLine;
            $this->currLine = $findLine + 1;
            return $this->aContent[$curLine];
        }
        return '';
    }
    
    /**
     * Search in current line or in key_line given as param
     * 
     * @param Regex $pattern
     * @param Int $key_line Linea del array aContent
     * @return Boolean if founded
     * 
     */
    function __search_pattern( $pattern, $key_line = null ) {
        if ( $key_line === null ) {
            $key_line = $this->currLine;
        }
        $cant = count( $this->aContent );
        if ( $key_line < count($this->aContent)) {            
            return preg_match( $pattern, $this->aContent[$key_line] );
        }
        return false;
    }
    
    
    
    /**
     * Search in current line
     * 
     * @param Regex $pattern
     * @param Int $key_line Linea del array aContent
     * @return Boolean if founded
     * 
     */
    function __search_next_pattern( $pattern, $key_line = null ) {
        if ( $key_line !== null ) {
            $this->currLine = $key_line;
        }
        
        if (count($this->aContent)==0) return false;
        
        do{
            if ( preg_match( $pattern, $this->aContent[$this->currLine] ) ) {
               return true;
            }
        } while ( $this->nextLine() > -1 );
            
        return false;
    }
    
    
}
