<?php

$this->extend('/Common/admin_index');
$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Sky KPI'), $this->here);

?>



<div class="skyKpis index">
	<h2><?php echo __('Kpi Counters'); ?></h2>
	<table class="table table-condensed">
	<tr>
			<th><?php echo $this->Paginator->sort('col_name'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('string_format'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($skyKpis as $skyKpi): ?>
	<tr>
		<td><?php echo h($skyKpi['Counter']['col_name']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['Counter']['name']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['Counter']['string_format']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $skyKpi['Counter']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $skyKpi['Counter']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $skyKpi['Counter']['id']), null, __('Are you sure you want to delete # %s?', $skyKpi['Counter']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>