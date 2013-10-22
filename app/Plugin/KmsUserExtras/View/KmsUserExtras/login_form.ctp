
<div class="home-login">
    <?php
    if (!$this->Session->check('Auth.User.id')) {
   

    echo $this->Form->create('User', array(
                'url' => array(
                    'plugin'=>'users',
                    'controller' => 'users', 
                    'action' => 'login'
                ),
                'id' => 'login-form'
                ));
    ?>
        <h2>User Login</h2>
        <?php
        $this->Form->inputDefaults(array(
					'label' => false,
				));
				echo $this->Form->input('username', array(
					'placeholder' => __d('croogo', 'Username'),
					'div' => 'input-group ill-input initialised',
                                    ));
                                    echo $this->Form->input('password', array(
                                            'placeholder' => 'Password',
                                            'div' => 'input-group ill-input initialised',
                                            'class' => 'input-block-level',
                                    ));
                ?>


            <div class="input-group">
                <?php
                
                echo $this->Form->submit('Sign In', array('class'=>'submit-btn'));
                
                echo $this->Html->link("<small><em>Use External Login (AD/LADP)</em></small>", '/simple_saml_login', array('escape'=>false));
              ?>
              <small>Forgot <?php echo $this->Html->link("Username / Password",'/forgot');?></small>
            </div>
        <?php echo $this->Form->end(); ?>

    <?php
    } else {
        echo $this->Html->link('You are logged in, Go To Dashboard', '/dashboard');
    }
    ?>
</div>
