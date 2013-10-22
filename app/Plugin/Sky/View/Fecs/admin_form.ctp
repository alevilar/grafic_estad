<?php
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('sky', 'Fec'), array('plugin' => 'sky', 'controller' => 'fecs', 'action' => 'index'));

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->data['Fec']['id'], array(
		'plugin' => 'sky', 'controller' => 'fecs', 'action' => 'edit',
		$this->data['Fec']['id']
	));
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('sky', 'Add'), array('plugin' => 'sky','controller' => 'fecs', 'action' => 'add'));
}
?>

<?php echo $this->Form->create('Fec');?>

<div class="row-fluid">
	<div class="span8">

		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('sky', 'Fec')." ".$this->data['Fec']['id'], '#fec-main');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">

			<div id="fec-main" class="tab-pane">
			<?php
				echo $this->Form->input('id');
				
				$this->Form->inputDefaults(array(
					'class' => 'span10',
					'label' => false,
				));
				echo $this->Form->input('modulation', array(
					'label' => 'Modulación',
				));
				

				echo $this->Form->input('line_color', array(
					'label' => 'Color',
				));				
			?>
			</div>

			<?php echo $this->Croogo->adminTabs(); ?>
		</div>
	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Save'), array('button' => 'default')) .
			$this->Html->link(
			__d('croogo', 'Cancel'), array('action' => 'index'),
			array('button' => 'danger')) .
			
			$this->Html->endBox();

		echo $this->Croogo->adminBoxes();
	?>
	</div>

</div>
<?php echo $this->Form->end(); ?>