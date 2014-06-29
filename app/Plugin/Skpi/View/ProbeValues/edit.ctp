<div class="probeValues form">
<?php echo $this->Form->create('ProbeValue'); ?>
	<fieldset>
		<legend><?php echo __('Edit Probe Value'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('probe_id');
		echo $this->Form->input('dl');
		echo $this->Form->input('ul');
		echo $this->Form->input('date_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProbeValue.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ProbeValue.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Probe Values'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Probes'), array('controller' => 'probes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Probe'), array('controller' => 'probes', 'action' => 'add')); ?> </li>
	</ul>
</div>
