<?php if ( !$this->Session->check('Auth.User.id') ) { ?>
                        <a href="#user-login-box" id="link-login" role="button" class="btn" dat
a-toggle="modal">
                                User Login
                        </a>
                        <?php } else {
                        echo $this->Session->read('Auth.User.username')." - ".$this->Html->link
('My Dashboard','/dashboard')." | ".$this->Html->link('Logout','/users/users/logout');

                        }?>

