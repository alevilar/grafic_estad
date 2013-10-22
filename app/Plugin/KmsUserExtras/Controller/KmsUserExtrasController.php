<?php

App::uses('KmsUserExtrasAppController', 'KmsUserExtras.Controller');

/**
 * Example Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class KmsUserExtrasController extends KmsUserExtrasAppController {

	
	/**
	 * Controller name
	 *
	 * @var string
	 * @access public
	 */
	public $name = 'KmsUserExtras';
	
	
	/**
	 * Models used by the Controller
	 *
	 * @var array
	 * @access public
	 */
		public $uses = array('KmsUserExtras.KmsUserExtra');
	
	
	
	
	/**
	 * beforeFilter
	 *
	 * @return void
	 * @access public
	 */
	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->Security->csrfCheck = false; 
	
		$this->Security->unlockedActions[] = 'user_edit';
		$this->Security->unlockedActions[] = 'reset_password';
                
                $this->Auth->allow(array('login', 'login_form'));
	}
	

	/**
	 * 
	 * Edit current user (by session)
	 * 
	 * user_edit
	 *
	 * @return void
	 */
	public function user_edit() {
		$id = $this->Session->read('Auth.User.id');
		if (!empty($this->request->data)) {
			if ($this->KmsUserExtra->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The User has been saved, please logout and then login for the changes to take effect'), 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The User could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->KmsUserExtra->read(null, $id);
		}
		$this->set('title_for_layout', __('Edit User')." ".$this->Session->read('Auth.User.username'));
	}



	/**
	 * reset current user password
	 *
	 * @param integer $id
	 * @return void
	 * @access public
	 */
	public function reset_password() {
		$this->set('title_for_layout', __d('croogo', 'Reset password').": ".$this->Session->read('Auth.User.username') );
		$id = $this->Session->read('Auth.User.id');
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__d('croogo', 'Invalid User'), 'default', array('class' => 'error'));
		}
		if (!empty($this->request->data)) {
			if ($this->KmsUserExtra->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'Password has been reset.'), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'user_edit'));
			} else {
				$this->Session->setFlash(__d('croogo', 'Password could not be reset. Please, try again.'), 'default', array('class' => 'alert alert-error'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->KmsUserExtra->read(null, $id);
		}
	}



	/**
	 * 
	 * Edit current user (by session)
	 * 
	 * user_edit
	 *
	 * @return void
	 */
	public function interact() {
		$id = $this->Session->read('Auth.User.id');
		if (!empty($this->request->data)) {
                    
                    $CC = ClassRegistry::init('Contacts.Contact');
                    
                    $contact = $CC->find('first', array(
                                    'conditions'=> array(
                                            'Contact.email' => $this->request->data['User']['email'])));
                        
                    if (!empty($this->request->data['User']['email'])){
                        if (empty($contact)) {
                            $data = array(
                                'Contact' => array(
                                    'alias' => $this->request->data['User']['username'],
                                    'email' => $this->request->data['User']['email'],
                                    'title' => $this->request->data['User']['username'].' Contact Form',
                            ));
                            $CC->save($data);
                        }
                    } else {
                        $CC->delete($contact['Contact']['id']);
                    }
                    
                    if ($this->KmsUserExtra->save($this->request->data)) {
                            $this->Session->setFlash(__d('croogo', 'Your profile has been saved'), 'default', array('class' => 'alert alert-success'));
                            $this->request->data = $this->KmsUserExtra->read(null, $id);
                    } else {
                            $this->Session->setFlash(__d('croogo', 'Your profile could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-error'));
                    }
		} else {
			$this->request->data = $this->KmsUserExtra->read(null, $id);
		}
		$this->set('title_for_layout', __('Interact <span class="muted">>> Socialize, Hook User, Maintain Contacts & Messages</span>'));
	}

        
        
        public function login(){
            App::uses('SamlAuthenticate', 'KmsAuth.Component/Auth');
            SamlAuthenticate::login();
        }
        
        
        public function login_form(){
            $this->layout = false;
        }

}
