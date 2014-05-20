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


$this->start('search');

?>



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



<?php

if (!empty($sites_list)) {
        echo $this->Form->input('site_id', array(
            'type' => 'select',
            'label' => false,
            'div' => array(
                'class' => 'pull-left'
            ),
            'default' => $this->request->data['DataDay']['site_id'],
            'empty' => 'Seleccione Sitio',
            'options' => $sites_list,
            'change' => 'changeSitio'
                )
        );
    }

$this->start('end');



echo $this->element('Skpi.sitio_sectores_y_carriers');

 ?>

<div class="clearfix"></div>






<?php

echo $this->element('kpis_table', array(
        'days' => $days,
        'kpis' => $kpis,
    ));
?>