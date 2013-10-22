
<?php echo $this->Form->create('User');?>
<div class="row-fluid">
	<div class="span8">
		
			<div id="reset-password" class="tab-pane">
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('password', array('label' => __d('croogo', 'New Password'), 'value' => ''));
				echo $this->Form->input('verify_password', array('label' => __d('croogo', 'Verify Password'), 'type' => 'password', 'value' => ''));
			?>
			</div>


	<?php
			echo $this->Form->button(__d('croogo', 'Reset'), array('button' => 'default'));
			
			echo $this->Html->link(
				__d('croogo', 'Cancel'),
				array('action' => 'user_edit'),
				array('button' => 'primary'));

	?>
	</div>
</div>
<?php echo $this->Form->end(); ?>
