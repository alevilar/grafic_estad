<?php 
$id = rand();
$idDivName = "container_$id";
$idMimoName = "mimo_$id";
$idMimoFullName = "mimo_full_$id";
?>
<div class="well" id="<?php echo $idDivName?>">
    <button type="button" class="close pull-right" data-dismiss="alert">&times;</button>
        <?php
        $out = "<b>Filtro >></b> ";
        if (!empty($this->data['LogMstation']['datetime'])) {
            $out .=  "Fecha y Hora exacta: " . $this->data['LogMstation']['datetime'] . " | ";
        }
        if (!empty($this->data['LogMstation']['datetime_from'])) {
            $out .=  "Fecha desde: " . $this->data['LogMstation']['datetime_from'] . " | ";
        }
        if (!empty($this->data['LogMstation']['datetime_to'])) {
            $out .=  "Fecha hasta: " . $this->data['LogMstation']['datetime_to'] . " | ";
        }
        if (!empty($this->data['LogMstation']['site_id'])) {
            $site = "";
            foreach($this->data['LogMstation']['site_id'] as $siteId) {
                $site .= $sites[$siteId] . ', ';
            }
            
            $out .=  "Sitio: " . trim($site, ', ') . " | ";
        }
        if (!empty($this->data['LogMstation']['sector_name'])) {
            $out .=  "Sector: " . $this->data['LogMstation']['sector_name'] . " | ";
        }
        if (!empty($this->data['LogMstation']['carrier_name'])) {
            $out .=  "Carrier: " . $this->data['LogMstation']['carrier_name'] . " | ";
        }
        if (!empty($this->data['LogMstation']['mstation_id'])) {
            $out .=  "MSI: " . $this->data['LogMstation']['mstation_id'] . " | ";
        }
        if (!empty($this->data['LogMstation']['mimo_id'])) {
            $mimo = "";
            foreach($this->data['LogMstation']['mimo_id'] as $mimoId) {
                $mimo .= $mimos[$mimoId] . ', ';
            }
            
            $out .=  "Mimo: " . trim($mimo, ', ') . " | ";
        }
        echo trim($out, " | ");
        ?>
<div class="row-fluid">
    
    <div class="span6">
        <div id="<?php echo $idMimoName?>" style="height: 500px"></div>
    </div>
    <div class="span6">
        <div id="<?php echo $idMimoFullName?>" style="height: 500px"></div>
    </div>
</div>




<?php
$data = array();
$legend = array();
$mimos = array();
$mimosColor = array();
$mimoFecsColor = array();
$cantTotal = 0;
foreach ($log_mstations as $l) {
    $name = $l['LogMstation']['mimo_id'] . " " . $l['DlFec']['modulation'];
    $legendName = "(" . $l[0]['cant'] . ") " . $name;
    $cantTotal += $l[0]['cant'];
    $data[] = array($legendName, (int) $l[0]['cant']);
    
    if (!isset($mimos[$l['LogMstation']['mimo_id']])) {
        $mimos[$l['LogMstation']['mimo_id']] = 0;
        $mimosColor[] = $l['Mimo']['line_color'];
    }
    $mimos[$l['LogMstation']['mimo_id']] += $l[0]['cant'];
    
    // calculo el promedio para "inventarle" un color
    $rgb = hex2rgb($l['DlFec']['line_color']);
    $rgb[0] = rgbRandom($rgb[0]);
    $rgb[1] = rgbRandom($rgb[1]);
    $rgb[2] = rgbRandom($rgb[2]);
    $mimoFecsColor[] = rgb2hex($rgb);
}
$mimos_a = array();
foreach ($mimos as $m=>$mv) {
    $mimos_a[] = array($m, $mv);
}
$mimos = $mimos_a;
?>



<script type="text/javascript">

    $(document).ready(function() {
        var data = <?php echo json_encode($data) ?>;
        var dataMimo = <?php echo json_encode($mimos) ?>;
        var mimoCOlor = <?php echo json_encode($mimosColor) ?>;
        var mimoFecCOlor = <?php echo json_encode($mimoFecsColor) ?>;
        jQuery.jqplot( "<?php echo $idMimoFullName ?>", [data],
                {
                    title: {
                        text: 'Mimo y Modulación (Total: <?php echo $cantTotal ?>)',
                        textColor: "rgb(102, 102, 102)",
                        fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                        fontSize: "19.2px",
                        textAlign: "center"
                    },
                    seriesColors: mimoFecCOlor,
                    seriesDefaults: {
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {
                            // Put data labels on the pie slices.
                            // By default, labels show the percentage of the slice.
                            showDataLabels: true
                        }
                    },
                    legend: {
                        show: true
                    }

                }
        );

        jQuery.jqplot("<?php echo $idMimoName?>", [dataMimo],
                {
                    title: {
                        text: 'Mimo',
                        textColor: "rgb(102, 102, 102)",
                        fontFamily: "'Trebuchet MS',Arial,Helvetica,sans-serif",
                        fontSize: "19.2px",
                        textAlign: "center"
                    },
                    seriesColors: mimoCOlor,
                    seriesDefaults: {
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {
                            // Put data labels on the pie slices.
                            // By default, labels show the percentage of the slice.
                            showDataLabels: true
                        }
                    },
                    legend: {
                        show: true
                    }

                }
        );

    });

</script>

</div>