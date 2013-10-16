<?php if (!$this->Session->check('Auth.User.id')) { ?>    

    <a href="#user-login-box" role="button" class="" data-toggle="modal">User Login</a>

    <!-- Modal -->
    <div id="user-login-box" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
        <?php echo $this->element('login_form') ?>
    </div>

    <?php
} else {
    ?>    
    <style>
        .top-login .message{
            font-weight: bolder;
            font-size: 8pt;
        }
    </style>
    <div class="top-login">
        <?php
        $userImage = $this->Session->read('Auth.User.image');
        if (!empty($userImage)) {
            echo $this->Html->image("../profiles/" . $userImage, array(
                'class' => 'img-circle kms-thumb',
                'style' => 'float: right;'));
        }
        ?>
        <p>
            <span><?php echo __("Welcome"); ?></span> <strong><?php echo $this->Session->read('Auth.User.username') ?></strong>
            <br><span><?php echo $this->Html->link(__('Change password'), array('plugin' =>'kms_user_extras', 'controller' => 'kms_user_extras', 'action' => 'reset_password'))?></span>
            <span style="margin-left: 10px;"><?php echo $this->Html->link(__("Sign Out"), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?></span>
        </p>
    </div>
    <?php
}
?>
