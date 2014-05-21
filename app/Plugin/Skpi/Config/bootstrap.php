<?php


define('SK_KPI_MAX_DL_ID', 1);
define('SK_KPI_MAX_UL_ID', 2);

define('SK_COUNTER_DL_AVG', 30);
define('SK_COUNTER_UL_AVG', 31);




CroogoNav::add('sky', array(
	'icon' => array('th', 'large'),
	'title' => __('Sky'),
	'url' => array(
		'admin' => true,
		'plugin' => 'skpi',
		'controller' => 'kpis',
		'action' => 'index',
	),
	'weight' => 50,
	'children' => array(
		'kpis' => array(
			'title' => __('Kpis'),
			'url' => array(
				'admin' => true,
				'plugin' => 'skpi',
				'controller' => 'kpis',
				'action' => 'index',
			),
			'weight' => 10,
		),
                'counters' => array(
			'title' => __('Counters'),
			'url' => array(
				'admin' => true,
				'plugin' => 'skpi',
				'controller' => 'kpiCounters',
				'action' => 'index',
			),
			'weight' => 11,
		),
	),
));