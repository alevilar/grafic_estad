<table class="table">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('probe_id'); ?></th>
			<th><?php echo $this->Paginator->sort('dl'); ?></th>
			<th><?php echo $this->Paginator->sort('ul'); ?></th>
			<th><?php echo $this->Paginator->sort('date_time'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($probeValues as $probeValue): ?>
	<tr>
		<td><?php echo h($probeValue['ProbeValue']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($probeValue['Probe']['name'], array('controller' => 'probes', 'action' => 'view', $probeValue['Probe']['id'])); ?>
		</td>
		<td><?php echo h($probeValue['ProbeValue']['dl']); ?>&nbsp;</td>
		<td><?php echo h($probeValue['ProbeValue']['ul']); ?>&nbsp;</td>
		<td><?php echo h($probeValue['ProbeValue']['date_time']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $probeValue['ProbeValue']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $probeValue['ProbeValue']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $probeValue['ProbeValue']['id']), null, __('Are you sure you want to delete # %s?', $probeValue['ProbeValue']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>