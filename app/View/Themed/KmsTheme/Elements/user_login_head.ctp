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
        	<p><span>Welcome</span> <strong><?php echo $this->Session->read('Auth.User.username') ?></strong>
                <?php
                     $messages = ClassRegistry::init('Message')->find('count', array(
                            'recursive' => -1,
                            'conditions' => array(
                                'Message.contact_id' => $this->Session->read('Auth.User.id'),
                                'Message.status' => 0,
                            )
                        )); 
                ?>
                </p>
            <p>
	       <?php if ($this->Session->read('Auth.User.role_id') == 1 ) { ?><?php echo $this->Html->link(__("Admin"), '/admin'); ?> |<?php } ?> 
	       <?php echo $this->Html->link( 'My Account', array( 'admin'=>false, 'plugin' => 'kms_user_extras', 'controller'=>'kms_user_extras', 'action'=>'user_edit')); ?> | 
               
               <?php 
               $mstxt = '';
               if ( $messages ) {
                    $mstxt = "($messages)";
                }
                echo $this->Html->link( "$mstxt Messages", array( 'admin'=>true, 'plugin' => 'contacts', 'controller'=>'messages', 'action'=>'my_index')); 
               
               
               ?> | 
               
	       <?php echo $this->Html->link(__("Sign Out"), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?></p>
    </div>
 <?php endif; ?>   
