<?php
if ($this->Session->check('Auth.User.id')) {
   // header('Location:'.$this->Html->url('/dashboard'));
} else {
   // header('Location:'.$this->Html->url('/users/users/login'));
}
