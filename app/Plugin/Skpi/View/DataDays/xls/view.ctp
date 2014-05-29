<?php

// KPI´s TABLE
echo $this->element('kpis_table', array(
        'days' => $days,
        'kpis' => $kpiValues,
        'site_id' => $site['Site']['id']
    ));


        
