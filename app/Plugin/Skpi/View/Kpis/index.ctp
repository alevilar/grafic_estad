<div class="skyKpis index">
	<h2><?php echo __('Sky Kpis'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('field_name'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('string_format'); ?></th>
			<th><?php echo $this->Paginator->sort('sql_threshold_warning'); ?></th>
			<th><?php echo $this->Paginator->sort('sql_threshold_danger'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($skyKpis as $skyKpi): ?>
	<tr>
		<td><?php echo h($skyKpi['SkyKpi']['id']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['SkyKpi']['field_name']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['SkyKpi']['name']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['SkyKpi']['string_format']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['SkyKpi']['sql_threshold_warning']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['SkyKpi']['sql_threshold_danger']); ?>&nbsp;</td>
		<td><?php echo h($skyKpi['SkyKpi']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $skyKpi['SkyKpi']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $skyKpi['SkyKpi']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $skyKpi['SkyKpi']['id']), null, __('Are you sure you want to delete # %s?', $skyKpi['SkyKpi']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Sky Kpi'), array('action' => 'add')); ?></li>
	</ul>
</div>
