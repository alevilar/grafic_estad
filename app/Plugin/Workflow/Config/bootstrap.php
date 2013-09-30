<?php

Croogo::hookBehavior('Node', 'Workflow.Workflow');
 
//Croogo::hookHelper('*', 'Workflow.Workflow');
//Croogo::hookComponent('Nodes.Nodes', 'Workflow.Workflow');
Croogo::hookComponent('Nodes', 'Workflow.Workflow');



Croogo::hookAdminTab('Nodes/admin_add', __d('croogo', 'Workflow'), 'Workflow.admin/workflow_tab');
Croogo::hookAdminTab('Nodes/admin_edit', __d('croogo', 'Workflow'), 'Workflow.admin/workflow_tab');

CroogoNav::add('settings.children.workflow', array(
		'title' => __d('croogo', 'Workflow'),
		'url' => array(
			'admin' => true,
			'plugin' => 'settings',
			'controller' => 'settings',
			'action' => 'prefix',
			'Workflow',
		),
	));



CroogoNav::add('workflow', array(
	'icon' => array('signal', 'large'),
	'title' => __('Workflow'),
	'url' => array(
		'admin' => true,
		'plugin' => 'kms',
		'controller' => 'organizations',
		'action' => 'index',
	),
	'weight' => 51,
	'children' => array(
		'states' => array(
			'title' => __('Content States'),
			'url' => array(
				'admin' => true,
				'plugin' => 'workflow',
				'controller' => 'states',
				'action' => 'index',
			),
			'weight' => 10,
		),
		'state_tables' => array(
			'title' => __('States Table'),
			'url' => array(
				'admin' => true,
				'plugin' => 'workflow',
				'controller' => 'state_tables',
				'action' => 'index',
			),
			'weight' => 20,
		),
		'workflow_help' => array(
			'title' => __('How It Works?'),
			'url' => array(
				'admin' => true,
				'plugin' => 'workflow',
				'controller' => 'states',
				'action' => 'how_does_it_works',
			),
			'weight' => 1,
		),
	),
));
