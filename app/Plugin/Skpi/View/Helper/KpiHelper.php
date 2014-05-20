<?php
App::uses('AppHelper', 'View/Helper');


class KpiHelper extends AppHelper {

    public $kpiFields = array();

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    public $helpers = array(
        'Html',
    );

/**
 * Before render callback. Called before the view file is rendered.
 *
 * @return void
 */
    public function beforeRender($viewFile) {

//     tCellshis->kpiFields = $kpiFields;
    }

/**
 * After render callback. Called after the view file is rendered
 * but before the layout has been rendered.
 *
 * @return void
 */
    public function afterRender($viewFile) {
    }

/**
 * Before layout callback. Called before the layout is rendered.
 *
 * @return void
 */
    public function beforeLayout($layoutFile) {
    }

/**
 * After layout callback. Called after the layout has rendered.
 *
 * @return void
 */
    public function afterLayout($layoutFile) {
    }


    public function tHead( $headers  ) {                          
        $out  = "";
        $out .= "<thead>";
        $out .= $this->Html->tableHeaders( $headers );
        $out .= "</thead>";        
        return $out;
    }


    /**
    *   Los Kpi luego de un find viene los registros para poner
    *   los SItios  de forma horizontal en la tabla
    *   esta funcion los da vuelta para que, de forma horizontal quede la fecha "date"
    *   @return array list of kpis
    **/
    public function darVueltaSiteDate ( $kpis, $fieldName ) {      

        // dar vuelta la tabla para que quede ordenado por fecha
        $newkpi = array();
        foreach ( $kpis as $k ) {     
            $site_id = $k['Carrier']['Sector']['Site']['id'];
            $site_name = $k['Carrier']['Sector']['Site']['name'];    
            $newkpi[ $k['DateKpi']['date'] ][ $site_id ]['site_name'] = $site_name;     
            
            $value = $k['DateKpi'][ $fieldName ];              
            $newkpi[ $k['DateKpi']['date'] ][ $site_id ]['field_value'] = $value;
                       
        }


        return $newkpi;
    }


    /**
    *   Los Kpi luego de un find viene los registros para poner
    *   los kpi de forma horizontal en la tabla
    *   esta funcion los da vuelta para que, de forma horizontal quede la fecha "date"
    *   @return array list of kpis
    **/
    public function darVueltaKpiDate ( $kpis ) {
        // dar vuelta la tabla para que quede ordenado por fecha
        $newkpi = array();
        foreach ( $kpis as $k ) {                 
            foreach ( $this->kpiFields as $kpfKey=>$kpfVal ) {             
                $value = $k['DateKpi'][ $kpfKey ];              
                $newkpi[ $k['DateKpi']['date'] ][ $kpfKey ] = $value;
            }           
        }
        return $newkpi;
    }






    /**
    *   Completa las celdas poniendo como primer indice de cada fila al nombre del campo
    *   "fieldName". Es para poner como columna principal al nombre. 
    *   Arma arrays solo con esos fieldnames
    *   Tambien formatea cada celda segun el fieldName que es
    *   Por último coloca el promedio como última columna
    *   @return array list of kpis
    **/
    public function arraysPorFieldNamesYAvg ( $kpis, $funArgs = array()) {
        $list = array();
                    

        foreach ($this->kpiFields as $fk=>$fn) {
            $cont = 0;
            $sum = 0;

            $list[$fk] = array();
            // coloco el nombre del campo como primer valor
            $list[$fk][] = array($this->Html->link($fn, array('action'=>'by_kpi', $fk)), array('class'=>'text-small field-name')); 

            // lleno los demas valores del array para el current fieldName
            foreach ( $kpis as $k ) {            
                $list[$fk][] = $this->format_bg_class( $fk, $k[$fk] );
                $sum += $k[$fk];
                $cont++;            
            }

            // coloco el promedio al final
            $list[$fk][] = $this->format_bg_class( $fk, $sum/$cont,  array('class' => 'kpi-avg') );
        }                    
        
        return $list;
    }

    public function thresholdEval($value, $sql_threshold_warning, $sql_threshold_danger){
        $out = '';
        if ( !empty($value) ) {
            if(!empty($sql_threshold_warning)) {
                // check warning
                $codeEval = str_replace("?", $value, $sql_threshold_warning);   
                $codeEval = "return ".$codeEval.";";                
                $out .= eval($codeEval)?' warning':'';
            }
             
            if(!empty($sql_threshold_danger)) {
                // check danger
                $codeEval = str_replace("?", $value, $sql_threshold_danger); 
                $codeEval = "return ".$codeEval.";";
                $out .= eval($codeEval)?' danger':'';
            }
        }
        // return value
        return trim($out);
    }

    /**
    *   Coloca la clase al fondo de la celda segun lo que vino en la funncion de threshold
    **/
    public function format_bg_class ( $value, $format, $ops = array()) {
        if (empty($value)){
            return $value;
        }
        $formatVal = $value;
        if (!empty($format)) {
            $value = round($value, 4);
            $formatVal = sprintf($format, $value);         
        }
        
        if (empty($ops['class'])) {
            $ops['class'] = '';
        }  else {
            $className = $ops['class'];
        }
        
        $ops['class'] .= ' kpi-value';
        
        
        if ( !empty($className)) {
            $ops['class'] .= " bg-".$className;    
            if ($className == 'danger') {
                $ops['title'] = 'Need Improve';
            } elseif( $className == 'warning' ) {
                $ops['title'] = 'Warning';
            }
        }
        return array(
                $formatVal,
                $ops
        );
        
    }


    /**
    *   Arma las celdas para ek array de $kpis que viene del controller
    *   @return string Html output
    **/
    public function tCells( $kpis, $algunaFunction = null, $funArgs = array() ) {
        if (  !empty($algunaFunction) ) {                   
            $kpis = $this->{$algunaFunction}( $kpis, $funArgs);
        }        
        $kpis = array_values($kpis);
        return $this->Html->tableCells( $kpis );
    }


    /**
    *   Formatea el valor de la celda dependiendo del fieldName
    *   @return string
    **/
    public function format( $field, $val ) {
        $out = $val;
        switch ( $field ){
            case 'max_dl':
            case 'max_ul':
                $out = $val."Kbit/s";
                break;
            case 'initial_ntwk_entry_success_rate':
            case 'initial_ntwk_entry_success_rate':
            case 'success_rate_of_ntwk_re_entry_idle_mode':
            case 'radio_dropt_rate':
            case 'network_disconnection_ratio':
            case 'ul_per':
            case 'dl_per':            
            case 'access_success_rate':
            case 'radio_access_rate':
            case 'carrier_dl_be_avg_traffic_rate':           
                $out = $val .'%';
                break;

            case 'num_actived_users':
                $out = $val;
                break;

            case 'avg_ul_slot_coding_eff':
            case 'avg_dl_slot_coding_eff':
                $out = $val .'bpsc';
                break;

            case 'avg_ntwk_entry_delay_users':
                $out = $val .'ms';
                break;

            default: 
                $out = $val;
                break;        
        }
        return $out;
    }



    public function threshold_class_name ( $fieldName, $value ) {
        $functionThresholdName = "__threshold_".$fieldName;
        if (!method_exists($this, $functionThresholdName)) {
            throw new Exception("unknown threshold method [$functionThresholdName]. Faltó definir el método para calcular el threshold para $fieldName. Asegurate de haber creado la funcion '$functionThresholdName' en KpiHelper");
        }
        
        return $this->{$functionThresholdName}($value);
    }


    private function __threshold_initial_ntwk_entry_success_rate ( $value ) {
        switch ( 1 ) {
            case $value > 80:
                // good
                return 'success';
            case $value < 70:
                return 'danger';
            default:
                return 'warning';
        }        
    }

    private function __threshold_success_rate_of_ntwk_re_entry_idle_mode ( $value ) {
        switch ( 1 ) {
            case $value > 95:
                // good
                return 'success';
            case $value < 85:
                // normal
                return 'danger';
            default:
                // need improve
                return 'warning';
        }  
    }
    private function __threshold_radio_dropt_rate ( $value ) {
        switch ( 1 ) {
            case $value < 2:
                // good
                return 'success';
            case $value > 5:
                return 'danger';
            default:
                return 'warning';
        }
    }

    private function __threshold_network_disconnection_ratio ( $value ) {
        switch ( 1 ) {
            case $value < 3:
                // good
                return 'success';
            case $value > 6:
                return 'danger';
            default:
                return 'warning';
        }
    }

    private function __threshold_carrier_dl_be_avg_traffic_rate ( $value ) {
        return "";
    }

    private function __threshold_avg_ntwk_entry_delay_users ( $value ) {
        switch ( 1 ) {
            case $value < 3000:
                // good
                return 'success';
            case $value > 10000:
                // normal
                return 'danger';
            default:
                // need improve
                return 'warning';
        }
    }

    private function __threshold_ul_per ( $value ) {
        switch ( 1 ) {
            case $value < 1:
                // good
                return 'success';
            case $value > 3:
                return 'danger';
            default:
                return 'warning';
        }
    }


    private function __threshold_dl_per ( $value ) {
        switch ( 1 ) {
            case $value < 1:
                // good
                return 'success';
            case $value > 2:
                return 'danger';
            default:                
                return 'warning';
        }
    }

    private function __threshold_avg_ul_slot_coding_eff () {
        return "";
    }

    private function __threshold_avg_dl_slot_coding_eff () {
        return "";
    }

    private function __threshold_num_actived_users () {
        return "";
    }

    private function __threshold_access_success_rate ( $value ) {
        switch ( 1 ) {
            case $value > 90:
                // good
                return 'success';
            case $value < 80:
                // need improve
                return 'danger';
            default:
                // normal
                return 'warning';
        }
    }


    private function __threshold_radio_access_rate ( $value ) {
        switch ( 1 ) {
            case $value > 97:
                // good
                return 'success';
            case $value < 90:
                return 'danger';
            default:                
                return 'warning';
        }
    } 


    private function __threshold_max_dl ( $value ) {
        return "";
    } 


    private function __threshold_max_ul ( $value ) {
        return "";
    }    


    

}

