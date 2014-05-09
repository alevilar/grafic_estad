<div class="skyKpis view">
<h2><?php echo __('Sky Kpi'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Field Name'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['field_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('String Format'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['string_format']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sql Threshold Warning'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['sql_threshold_warning']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sql Threshold Danger'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['sql_threshold_danger']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($skyKpi['SkyKpi']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sky Kpi'), array('action' => 'edit', $skyKpi['SkyKpi']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sky Kpi'), array('action' => 'delete', $skyKpi['SkyKpi']['id']), null, __('Are you sure you want to delete # %s?', $skyKpi['SkyKpi']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sky Kpis'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sky Kpi'), array('action' => 'add')); ?> </li>
	</ul>
</div>
