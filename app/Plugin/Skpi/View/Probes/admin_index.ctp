<?php

$this->extend('/Common/admin_index');
$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('sky', 'Probes'), $this->here);

?>



<div class="probes index">
	<h2><?php echo __('Probes'); ?></h2>
	<table class="table">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($probes as $probe): ?>
	<tr>
		<td><?php echo h($probe['Probe']['id']); ?>&nbsp;</td>
		<td><?php echo h($probe['Probe']['name']); ?>&nbsp;</td>
		<td><?php echo h($probe['Probe']['created']); ?>&nbsp;</td>
		<td><?php echo h($probe['Probe']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('admin'=>false,'action' => 'view', $probe['Probe']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $probe['Probe']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $probe['Probe']['id']), null, __('Are you sure you want to delete # %s?', $probe['Probe']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>

