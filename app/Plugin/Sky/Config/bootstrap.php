<?php


define('SK_INICIO_1_ROW', 'inicio_1_row');
define('SK_INICIO', 'inicio');
define('SK_SITENAME', 'site_name');
define('SK_FECHA', 'fecha');
define('SK_OM', 'om');
define('SK_COMANDO_ID', 'comando_id');
define('SK_RETCODE', 'retcode');
define('SK_TABLE_HEADER', 'table_header');
define('SK_MS_ROW', 'ms_row');
define('SK_CONTINUE', 'continue');
define('SK_END', 'end');
define('SK_SECTOR_ID', 'sector_id');
define('SK_CURR_LINE_END', 'currLine_end');


define('SK_NUMBER_RESULTS', 'number_results');
//define('SK_NUMBER_RESULTS_1ROW', 'number_results_1row');


define('SK_MS_CARRIER_ID', 'ms_carrier_id');
define('SK_MS_MSID', 'mstation_id');
define('SK_MS_STATUS', 'status_id');
define('SK_MS_PWR', 'mstation_pwr');
define('SK_MS_DLCINR', 'dl_cinr');
define('SK_MS_ULCINR', 'ul_cinr');
define('SK_MS_DLRSSI', 'dl_rssi');
define('SK_MS_ULRSSI', 'ul_rssi');
define('SK_MS_DLFEC', 'dl_fec_id');
define('SK_MS_ULFEC', 'ul_fec_id');
define('SK_MS_DLREPETITIONFATCTOR', 'dl_repetitionfatctor');
define('SK_MS_ULREPETITIONFATCTOR', 'ul_repetitionfatctor');
define('SK_MS_DLMIMOFLAG', 'mimo_id');
define('SK_MS_BENUM', 'benum');
define('SK_MS_NRTPSNUM', 'nrtpsnum');
define('SK_MS_RTPSNUM', 'rtpsnum');
define('SK_MS_ERTPSNUM', 'ertpsnum');
define('SK_MS_UGSNUM', 'ugsnum');
define('SK_MS_ULPER', 'ul_per_for_an_ms');
define('SK_MS_NIVALUE', 'ni_value');
define('SK_MS_DLTRAFFICRATE', 'dl_traffic_rate');
define('SK_MS_ULTRAFFICRATE', 'ul_traffic_rate');
define('SK_REPORTS', 'reports_total');





CroogoNav::add('settings.children.sky', array(
		'title' => __d('croogo', 'Sky'),
		'url' => array(
			'admin' => true,
			'plugin' => 'settings',
			'controller' => 'settings',
			'action' => 'prefix',
			'Sky',
		),
	));





function get_num_results_value ( $rawline ) {
    preg_match(PT_NUMBER_RESULTS, $rawline, $matches);
    if (!empty($matches[1])) {
        return $matches[1];
    }
    return 0;
}

function get_num_of_reports($rawline) {
    preg_match(PT_REPORTS, $rawline, $matches);
    if (!empty($matches[1])) {
        return $matches[1];
    }
    return 0;
    
}