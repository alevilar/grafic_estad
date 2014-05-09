<?php
echo $this->Element('kpi_site_date_search');



$urlParam = '';
foreach ($this->request->query as $k => $v) {
    if ($urlParam == ' ') {
        // es el primero
        $urlParam = '?$k=$v';
    } else {
        $urlParam .= "&$k=$v";
    }
}

$dateFrom = $dateTo = '';
if (!empty($this->request->data['KpiDataDay']['date_to'])) {
    $dateTo = $this->request->data['KpiDataDay']['date_to'];
}
if (!empty($this->request->data['KpiDataDay']['date_from'])) {
    $dateFrom = $this->request->data['KpiDataDay']['date_from'];
}
?>

<h2 style="float: left; margin-right: 10px;"><?php echo $title_for_layout ?></h2>


<script>
    $(function() {
        $('#site_id').change(function(ev) {

            var url = "<?php echo $this->Html->url($this->action); ?>";
            var dateFrom = "<?php echo $dateFrom ?>";
            var dateTo = "<?php echo $dateTo ?>";
            var value = $(ev.target).val();
            if (dateFrom) {
                dateFrom = "/" + dateFrom;
            }
            if (dateTo) {
                dateTo = "/" + dateTo;
            }
            var urlFull = url + "/" + value + dateFrom + dateTo;

            window.location.href = urlFull;
        });
    });
</script>


<div class="btn-toolbar pull-right">
    <?php
    if (!empty($sites_list)) {
        echo $this->Form->input('site_id', array(
            'type' => 'select',
            'label' => false,
            'div' => array(
                'class' => 'pull-left'
            ),
            'default' => $this->request->data['KpiDataDay']['site_id'],
            'empty' => 'Seleccione Sitio',
            'options' => $sites_list,
            'change' => 'changeSitio'
                )
        );
    }
    echo "&nbsp;&nbsp;";
    echo $this->Html->link('Sitio: '.$site['Site']['name'], array(
				'action' => 'by_site', $site['Site']['id'], $dateFrom, $dateTo),
				array(
                                    'class' => 'btn btn-primary'
				)
			);
    
    foreach ($site['Sector'] as $sec) {
        ?>


        <div class="btn-group">
            <?php
            echo $this->Html->link('Sector ' . $sec['name'], array(
                'action' => 'by_sector', $sec['id'], $dateFrom, $dateTo), array(
                'class' => 'btn btn-primary'
                    )
            );

            foreach ($sec['Carrier'] as $car) {
                echo $this->Html->link('Carrier ' . $car['name'], array(
                    'action' => 'by_carrier', $car['id'], $dateFrom, $dateTo), array(
                    'class' => 'btn'
                        )
                );
            }
            ?>
        </div>


        <?php
    }
    ?>
</div>

<div class="clearfix"></div>

<?php
//$kpis = $this->Kpi->darVueltaKpiDate( $kpis );
?>
<table class="table table-bordered table-condensed table-kpis table-hover">
<?php
$kpisDates = array_values($days);
$headers = array();
// formatear la fecha
foreach ($kpisDates as $date) {
    $headers[] = date('d-m-y', strtotime($date));
}
// colocar al inicio el texto        
array_unshift($headers, 'Kpis');
// colocar al final
$headers[] = "AVG";

echo $this->Kpi->tHead($headers);

//$kpis = $this->Kpi->darVueltaKpiDate($kpis );


$cels = array();
foreach ($kpis as $k) {
    $row = array();
    $row[] = $this->Html->link($k['Kpi']['name'], 'kpi_values_x_sitio/' . $k['Kpi']['id']);
    $avg = 0;
    $i = 0;
    foreach ($k['Day'] as $day) {
        $val = $day[0]['valor'];
        if ($val) {
            $avg += $val;
            $i++;
        }
        $class = $this->Kpi->thresholdEval($val, $k['Kpi']['sql_threshold_warning'], $k['Kpi']['sql_threshold_danger']);
        $ops['class'] = $class;
        $row[] = $this->Kpi->format_bg_class($val, $k['Kpi']['string_format'], $ops);
    }
    if ($i) {
        $val = $avg / $i;
        $class = $this->Kpi->thresholdEval($val, $k['Kpi']['sql_threshold_warning'], $k['Kpi']['sql_threshold_danger']);
        $ops['class'] = $class;
        $val = $this->Kpi->format_bg_class($val, $k['Kpi']['string_format'], $ops);
    } else {
        $val = '';
    }
    $row[] = $val;
    $cels[] = $row;
}
echo $this->Html->tableCells($cels);
//echo $this->Kpi->tCells( $kpis , 'arraysPorFieldNamesYAvg');       
?>

</table>
