<?php
$this->viewVars['title_for_layout'] = __d('sky', 'Probes');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Probes'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Probe']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Probe: ' . $this->data['Probe']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

?>

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

