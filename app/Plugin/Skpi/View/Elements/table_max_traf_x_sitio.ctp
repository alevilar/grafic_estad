<?php
function find_row_for_day( $day, $kData){
    $dl_val = '&nbsp;';
    $ul_val = '&nbsp;';
    foreach ( $kData as $k ) {
        $dd = date('Y-m-d', strtotime($k['SiteMaximsDailyValue']['ml_datetime']));
        if ( $dd == $day ) {
            $dl_val = sprintf("<b>%.3g</b>",$k['SiteMaximsDailyValue']['dl_value']);
            $ul_val = sprintf("%.3g",$k['SiteMaximsDailyValue']['ul_value']);
            break;
        }  
    }

    return array($dl_val, $ul_val);
}


$cells = array();
$dataDays = array();
foreach ( $sitesMaxims as $siteId => $k ) {  
    $url = array(
        'controller' => 'SiteMaximsDailyValues',
        'action' => 'graph_jplot',
        $siteId,
        );
    if ( !empty($busqueda) ) {
        $url[] = $this->request->data['SiteMaximsDailyValue']['date_from'];
        if (!empty($this->request->data['SiteMaximsDailyValue']['date_to'])) 
            $url[] = $this->request->data['SiteMaximsDailyValue']['date_to'];
    }
    $url = $this->Html->url($url,true);

    $imp = "<input type='radio' name='selected_site' value='$siteId' id='selected-radio-$siteId' data-url='$url'>";
    $row = array( $imp . $sites[$siteId] );

    // recorrer los valores y seguir armando el array para la fila
    // por cada dia
    $i = 0;
    foreach ($days as $day ) {
        $rws = find_row_for_day( $day, $k);
        $row[] = $rws[0]; // DL
        $row[] = $rws[1]; // UL
    }
    $cells[] = $row;
}
?>
    



<table class="table table-bordered table-condensed table-kpis table-hover">

        <thead>
        <?php
                $header2= array();
                $daysHead = array();
                foreach( $days as $date) {
                    $header2[] = 'DL';
                    $header2[] = 'UL';
                    $date = date('Y-m-d', strtotime($date));
                    if ( $date  == date('Y-m-d', strtotime('now') ))  {
                        $daysHead[] = 'Hoy(parcial)';
                    } else {
                        $daysHead[] = strftime("%a %e, %b", strtotime($date));
                    }
                }        
                ?>
                <tr>
                    <th>&nbsp;</th>
                <?php
                foreach ( $daysHead as $date) {
                    echo "<th colspan='2'>$date</th>";
                }
                ?>
                </tr>

                <?php

                array_unshift( $header2, 'Sitio');
                echo $this->Html->tableHeaders( $header2 );      

                
        ?>
        </thead>


        <?php
            echo $this->Kpi->tCells( $cells );
        ?>
        </table>