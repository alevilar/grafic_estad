<?php
$this->extend('/Common/admin_edit');

$this->Html->script(array('/taxonomy/js/terms'), false);

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'));



echo $this->Form->create('State', array(
	'url' => '/' . $this->request->url,
));

?>
<div class="row-fluid">
	<div class="span8">

		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'State'), '#state-basic');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id="state-basic" class="tab-pane">
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('name');
				echo $this->Form->input('order');
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
				__d('croogo', 'Cancel'),
				array('action' => 'index'),
				array('button' => 'danger')
			) .
			$this->Html->endBox();
		echo $this->Croogo->adminBoxes();
	?>
	</div>
</div>
<?php echo $this->Form->end(); ?>
