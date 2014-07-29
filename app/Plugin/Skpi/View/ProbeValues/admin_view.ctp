<div class="probeValues view">
<h2><?php echo __('Probe Value'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($probeValue['ProbeValue']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Probe'); ?></dt>
		<dd>
			<?php echo $this->Html->link($probeValue['Probe']['name'], array('controller' => 'probes', 'action' => 'view', $probeValue['Probe']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dl'); ?></dt>
		<dd>
			<?php echo h($probeValue['ProbeValue']['dl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ul'); ?></dt>
		<dd>
			<?php echo h($probeValue['ProbeValue']['ul']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Time'); ?></dt>
		<dd>
			<?php echo h($probeValue['ProbeValue']['date_time']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Probe Value'), array('action' => 'edit', $probeValue['ProbeValue']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Probe Value'), array('action' => 'delete', $probeValue['ProbeValue']['id']), null, __('Are you sure you want to delete # %s?', $probeValue['ProbeValue']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Probe Values'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Probe Value'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Probes'), array('controller' => 'probes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Probe'), array('controller' => 'probes', 'action' => 'add')); ?> </li>
	</ul>
</div>
