<?php

App::uses('CroogoAppController', 'Croogo.Controller');

/**
 * Base Application Controller
 *
 * @package  Croogo
 * @link     http://www.croogo.org
 */
class AppController extends CroogoAppController
{

    public $components = array(
        'Croogo.Croogo',
        //'Security',
        'Security' => array(
            'csrfUseOnce' => false
        ),
        'Auth' => array(
            'loginRedirect' => '/dashboard',
            'logoutRedirect' => '/'
        ),
        //'Auth' => array( 		
        //        'authenticate' => array('Saml.Saml')
        //),
        //'Saml.Saml',
        'Acl',
        'Session',
        'RequestHandler',
        'DebugKit.Toolbar'
    );

    function beforeFilter(){
        $this->Session->read('Auth.redirect'. '/dashboard');
        $this->Auth->loginRedirect = '/dashboard';
        return parent::beforeFilter();
    }
}
