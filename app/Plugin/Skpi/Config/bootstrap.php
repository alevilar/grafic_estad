<?php


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
		'sites' => array(
			'title' => __('Sites'),
			'url' => array(
				'admin' => true,
				'plugin' => 'sky',
				'controller' => 'sites',
				'action' => 'index',
			),
			'weight' => 9,
		),
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
				'controller' => 'counters',
				'action' => 'index',
			),
			'weight' => 11,
		),
		'metrics' => array(
			'title' => __('Métricas'),
			'url' => array(
				'admin' => true,
				'plugin' => 'skpi',
				'controller' => 'data_counters',
				'action' => 'index',
			),
			'weight' => 11,
		),
	),
));


CroogoNav::add('sky_probes', array(
	'icon' => array('th', 'large'),
	'title' => __('Probes'),
	'url' => '#',
	'weight' => 50,
	'children' => array(		
		'probes' => array(
			'title' => __('Probes'),
			'url' => array(
				'admin' => true,
				'plugin' => 'skpi',
				'controller' => 'probes',
				'action' => 'index',
			),
			'weight' => 11,
		),
		'probes_values' => array(
			'title' => __('Probes Values'),
			'url' => array(
				'admin' => true,
				'plugin' => 'skpi',
				'controller' => 'probe_values',
				'action' => 'index',
			),
			'weight' => 12,
		),
	),
));
