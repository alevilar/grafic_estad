<?php

CroogoRouter::connect('/users/edit', array('plugin' => 'kmsUserExtras', 'controller' => 'kms_user_extras', 'action' => 'user_edit'));


Router::redirect('/login/login_form', '/login_form');
CroogoRouter::connect('/login_form', array(
    'plugin' => 'kmsUserExtras', 
    'controller' => 'kms_user_extras', 
    'action' => 'login_form'));


CroogoRouter::connect('/simple_saml_login', array(
    'plugin' => 'kmsUserExtras', 
    'controller' => 'kms_user_extras', 
    'action' => 'login')
);



// Change Home Page
CroogoRouter::connect('/interact', array(
	'plugin' => 'KmsUserExtras', 'controller' => 'KmsUserExtras', 'action' => 'interact'
));
