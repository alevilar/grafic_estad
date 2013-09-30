<?php if ( !$this->Session->check('Auth.User.id') ) { ?>
                        <a href="#user-login-box" id="link-login" role="button" class="btn" dat
a-toggle="modal">
                                User Login
                        </a>
                        <?php } else {
                        
                        echo $this->Session->read('Auth.User.username');
                        echo " - ";
                        echo $this->Html->link( 'My Profile', array( 'admin'=>false, 'plugin' => 'kms_user_extras', 'controller'=>'kms_user_extras', 'action'=>'user_edit'));
                        echo " | ";
                        echo $this->Html->link('My Dashboard','/dashboard')." | ".$this->Html->link('Logout','/users/users/logout');

                        }?>

