<div class="users form">
	<?php
	 echo $this->Html->link('reset My Password', array(
	 			'admin' => false, 
	 			'plugin' => 'kms_user_extras',
	 			'controller' => 'kms_user_extras',
	 			'action' => 'reset_password')
				);
	 
	 echo $this->Form->create('User', array('type' => 'file'));?>
		<fieldset>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('username');
			echo $this->Form->input('name');
			echo $this->Form->input('email');
			echo $this->Form->input('website');
			
			echo $this->Form->hidden('image');
			if ( !empty($this->data['User']['image']) ) {
				echo $this->Html->image("../profiles/".$this->data['User']['image'], array('style' => 'float: left; width: 100px; margin-right:20px; margin-bottom: 10px'));			
			}
			echo $this->Form->input('file', array('type' => 'file'));
			
			
			$this->Form->unlockField('file');
			$this->Form->unlockField('image');
		?>
			<div class="clearfix"></div>			
			<?php			

			echo $this->Form->input('twitter');
			echo $this->Form->input('facebook');

                        ?>
		</fieldset>
		
	<?php echo $this->Form->end('Submit');?>
</div>