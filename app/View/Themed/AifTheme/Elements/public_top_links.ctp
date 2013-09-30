


<div class="top-links">
    <div class="top-social">
        <span>Follow Us:</span>
        <a href="#" class="linkdin">Linkdin</a>
        <a href="#" class="facebook">Facebook</a>
        <a href="#" class="mail">Email</a>
    </div>
    <div class="top-right-link">
        <?php
        if (!$this->Session->check('Auth.User.id')) {
            echo $this->Html->link('User Login', '/users/users/login');
            ?>
            &nbsp;|&nbsp;<a href="#">Register</a>
            <?php
        } else {
            echo $this->Session->read('Auth.User.username');
            echo " - ";
            echo $this->Html->link('My Account', array('admin' => false, 'plugin' => 'kms_user_extras', 'controller' => 'kms_user_extras', 'action' => 'user_edit'));
            echo " | ";
            echo $this->Html->link('My Dashboard', '/dashboard') . " | " . $this->Html->link('Logout', '/users/users/logout');
        }
        ?>
    </div>
</div>