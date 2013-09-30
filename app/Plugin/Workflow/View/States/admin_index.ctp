<?php

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Workflow'), array('plugin' => 'workflow', 'controller' => 'states', 'action' => 'index'));
?>

<?php $this->start('actions'); ?>
<?php
	echo $this->Croogo->adminAction(
		__d('croogo', 'New State'),
		array('action' => 'add')
	);
?>
<?php $this->end(); ?>

<?php
	if (isset($this->params['named'])) {
		foreach ($this->params['named'] as $nn => $nv) {
			$this->Paginator->options['url'][] = $nn . ':' . $nv;
		}
	}

	echo $this->Form->create('State', array(
		'url' => array(
			'controller' => 'states',
			'action' => 'add',
		),
	));
?>
<table class="table table-striped">
<?php
	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id', __d('croogo', 'Id')),
		$this->Paginator->sort('name', __d('croogo', 'Name')),
		__d('croogo', 'Actions'),
	));
?>
	<thead>
		<?php echo $tableHeaders; ?>
	</thead>
<?php

	$rows = array();
	foreach ($states as $state) :
		$actions = array();
		
		$actions[] = $this->Croogo->adminRowActions($state['State']['id']);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'edit', $state['State']['id']),
			array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'states', 'action' => 'delete', $state['State']['id']),
			array('icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item')),
			__d('croogo', 'Are you sure?'));
		$actions = $this->Html->div('item-actions', implode(' ', $actions));
		$rows[] = array(
			$state['State']['id'],
			$this->Html->link($state['State']['name'], array('controller' => 'states', 'action' => 'index', $state['State']['id'])),
			$actions,
		);
	endforeach;

	echo $this->Html->tableCells($rows);
?>
</table>
