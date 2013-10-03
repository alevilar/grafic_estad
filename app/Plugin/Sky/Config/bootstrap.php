<?php

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




