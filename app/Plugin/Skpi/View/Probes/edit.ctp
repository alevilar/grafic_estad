<div class="probes form">
<?php echo $this->Form->create('Probe'); ?>
	<fieldset>
		<legend><?php echo __('Edit Probe'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Probe.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Probe.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Probes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Probe Datas'), array('controller' => 'probe_datas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Probe Data'), array('controller' => 'probe_datas', 'action' => 'add')); ?> </li>
	</ul>
</div>
