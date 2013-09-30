<?php

//$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Workflow'), array('plugin' => 'workflow', 'controller' => 'state_tables', 'action' => 'index'));
?>




<?php
	if (isset($this->params['named'])) {
		foreach ($this->params['named'] as $nn => $nv) {
			$this->Paginator->options['url'][] = $nn . ':' . $nv;
		}
	}

	echo $this->Form->create('StateTable', array(
		'url' => array(
			'controller' => 'state_tables',
			'action' => 'table',
		),
	));
	
	
	echo $this->Form->input('role_id');
	echo $this->Form->input('type_id');
	
	echo $this->Form->end('Change Table');
?>


