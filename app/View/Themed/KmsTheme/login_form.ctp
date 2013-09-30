 <?php 
 
 /*
 * We set a variable depending on whether the user is authenticated or not.
 * This allows us to show the user a login link or a logout link depending
 * on the authentication state.
 */
 //if ($this->Session->check('Auth.User.id')) return "";
 
 ?>
<div class="login-continer">
	<div class="login-box">
		<h2>Access Portal</h2>
	    
		
		<?php echo $this->Form->create('User', array(
						'url' => array('plugin'=>'users','controller' => 'users', 'action' => 'login'),
						'class' => 'login-form'
						));?>
		<div class="box">
			<div class="box-content">
			<?php
				$this->Form->inputDefaults(array(
					'label' => false,
				));
				echo $this->Form->input('username', array(
					'placeholder' => __d('croogo', 'Username'),
				//	'div' => 'input-prepend text',
					'class' => 'input-block-level',
				));
				echo $this->Form->input('password', array(
					'placeholder' => 'Password',
				//	'div' => 'input-prepend password',
					'class' => 'input-block-level',
				));
				if (Configure::read('Access Control.autoLoginDuration')):
					echo $this->Form->input('remember', array(
						'label' => __d('croogo', 'Remember me?'),
						'type' => 'checkbox',
						'default' => false,
					));
				endif;
				echo $this->Form->button(__d('croogo', 'Log In'), array('class' => 'btn-danger'));
				echo $this->Html->link(__d('croogo', 'Forgot password?'), array(
					'admin' => false,
					'controller' => 'users',
					'action' => 'forgot',
					), array(
					'class' => 'forgot',
					'style' => 'float: right'
				));
			?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>

	</div><!-- end of login-box -->
</div>
