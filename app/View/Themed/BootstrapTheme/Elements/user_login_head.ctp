 <?php if ($this->Session->read('Auth.User.id')): ?>
<style>
    .top-login .message{
        font-weight: bolder;
        font-size: 8pt;
    }
</style>
    <div class="top-login">
    		<?php
    		$userImage = $this->Session->read('Auth.User.image');
    		if ( !empty($userImage) ) {
				echo $this->Html->image("../profiles/".$userImage, array(
						'class' => 'img-circle kms-thumb',
						'style' => 'float: right;'));			
			}
			?>
        	<p>
                    <span><?php echo __("Welcome");?></span> <strong><?php echo $this->Session->read('Auth.User.username') ?></strong>
                    <span style="margin-left: 10px;"><?php echo $this->Html->link(__("Sign Out"), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?></span>
                </p>
    </div>
 <?php endif; ?>   
