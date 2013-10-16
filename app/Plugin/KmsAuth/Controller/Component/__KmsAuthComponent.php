<?php
/**
 * Authentication component
 *
 * Manages user logins and permissions.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller.Component
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */


App::uses('Component', 'Controller/Component');
App::uses('Router', 'Routing');
App::uses('Security', 'Utility');
App::uses('Debugger', 'Utility');
App::uses('Hash', 'Utility');
App::uses('CakeSession', 'Model/Datasource');
App::uses('BaseAuthorize', 'Controller/Component/Auth');
App::uses('BaseAuthenticate', 'Controller/Component/Auth');
App::uses('User', 'Users.Model');

/**
 * Authentication control component class
 *
 * Binds access control with user authentication and session management.
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
 */
class KmsAuthComponent extends Component {

	
	/**
 * Controller actions for which user validation is not required.
 *
 * @var array
 * @see AuthComponent::allow()
 */
	public $allowedActions = array();
	
	
	

/**
 * An array of authorization objects to use for authorizing users. You can configure
 * multiple adapters and they will be checked sequentially when authorization checks are done.
 *
 * {{{
 *	$this->Auth->authorize = array(
 *		'Crud' => array(
 *			'actionPath' => 'controllers/'
 *		)
 *	);
 * }}}
 *
 * Using the class name without 'Authorize' as the key, you can pass in an array of settings for each
 * authorization object. Additionally you can define settings that should be set to all authorization objects
 * using the 'all' key:
 *
 * {{{
 *	$this->Auth->authorize = array(
 *		'all' => array(
 *			'actionPath' => 'controllers/'
 *		),
 *		'Crud',
 *		'CustomAuth'
 *	);
 * }}}
 *
 * You can also use AuthComponent::ALL instead of the string 'all'
 *
 * @var mixed
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html#authorization
 */
	public $authorize = false;
	
	
	public $Saml = null;
	

/**
 * The session key name where the record of the current user is stored. If
 * unspecified, it will be "Auth.User".
 *
 * @var string
 */
	public static $sessionKey = 'Auth.User';
	

/**
 * Controls handling of unauthorized access.
 * - For default value `true` unauthorized user is redirected to the referrer URL
 *   or AuthComponent::$loginRedirect or '/'.
 * - If set to a string or array the value is used as an URL to redirect to.
 * - If set to false a ForbiddenException exception is thrown instead of redirecting.
 *
 * @var mixed
 */
	public $unauthorizedRedirect = false;


/**
 * Main execution method. Handles redirecting of invalid users, and processing
 * of login form data.
 *
 * @param Controller $controller A reference to the instantiating controller object
 * @return boolean
 */
	public function startup(Controller $controller) {
            
            $controller->Components->load('Auth', array(
			'className' => 'KmsAuth.KmsAuth',
			'authenticate' => array('KmsAuth.Saml', 'Form')
            ));

		//$this->constructAuthenticate();		
		App::uses('SamlAuthenticate', 'KmsAuth.Controller/Component/Auth');
		$this->Saml = new SamlAuthenticate($this->_Collection, $settings = array());
		
		$this->__samlToCakeSession();
		
		
		$methods = array_flip(array_map('strtolower', $controller->methods));
		$action = strtolower($controller->request->params['action']);

		$isMissingAction = (
			$controller->scaffold === false &&
			!isset($methods[$action])
		);

		if ($isMissingAction) {
			return true;
		}

		if (!$this->_setDefaults()) {
			return false;
		}
		$request = $controller->request;

		$url = '';

		if (isset($request->url)) {
			$url = $request->url;
		}
		$url = Router::normalize($url);
		$loginAction = Router::normalize($this->loginAction);

		if ($this->allowedActions == null) {
			$this->allowedActions = array();
		}
		if ($loginAction != $url && in_array($action, array_map('strtolower', $this->allowedActions))) {
			return true;
		}
	

		if ( empty($this->authorize) || $this->isAuthorized($this->user()) ) {			
			return true;
		}

		return $this->_unauthorized($controller);
		
	}


 public function __samlToCakeSession(){
 	CakeSession::delete('Auth.User');
 	if ($this->isAuthorized() && !CakeSession::check('Auth.User')){
		
	 	$samlAtts = $this->Saml->getAttributes();
		$User = ClassRegistry::init('Users.User');
		$User->recursive = 1;
		$userData = $User->findByUsername($samlAtts['uid'][0]);
		foreach ($samlAtts as $key => $value) {
			$userData['User']['SamlData'][$key] = $value[0];
		}
 	
		CakeSession::write('Auth.User', $userData['User']);
	} 

 }
 
 
 
 
/**
 * Takes a list of actions in the current controller for which authentication is not required, or
 * no parameters to allow all actions.
 *
 * You can use allow with either an array, or var args.
 *
 * `$this->Auth->allow(array('edit', 'add'));` or
 * `$this->Auth->allow('edit', 'add');` or
 * `$this->Auth->allow();` to allow all actions
 *
 * @param string|array $action,... Controller action name or array of actions
 * @return void
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html#making-actions-public
 */
	public function allow($action = null) {
		$args = func_get_args();
		if (empty($args) || $action === null) {
			$this->allowedActions = $this->_methods;
			return;
		}
		if (isset($args[0]) && is_array($args[0])) {
			$args = $args[0];
		}
		$this->allowedActions = array_merge($this->allowedActions, $args);
	}


/**
 * Attempts to introspect the correct values for object properties.
 *
 * @return boolean
 */
	protected function _setDefaults() {
		$defaults = array(
			'logoutRedirect' => $this->loginAction,
			'authError' => __d('cake', 'You are not authorized to access that location.')
		);
		foreach ($defaults as $key => $value) {
			if (empty($this->{$key})) {
				$this->{$key} = $value;
			}
		}
		return true;
	}
	
	

/**
 * Check if the provided user is authorized for the request.
 *
 * Uses the configured Authorization adapters to check whether or not a user is authorized.
 * Each adapter will be checked in sequence, if any of them return true, then the user will
 * be authorized for the request.
 *
 * @param array $user The user to check the authorization of. If empty the user in the session will be used.
 * @param CakeRequest $request The request to authenticate for. If empty, the current request will be used.
 * @return boolean True if $user is authorized, otherwise false
 */
	public function isAuthorized($user = null, CakeRequest $request = null) {		
		return $this->Saml->isAuthenticated();
	}
	
	
	public static function user($key = null) {		
		if (!CakeSession::check(self::$sessionKey)) {
			return null;
		}
		

		$user = CakeSession::read(self::$sessionKey);

		if ($key === null) {
			return $user;
		}
		$kkk = Hash::get($user, $key);
		return $kkk;
	}
	


	public function login($user = null) {
		return $this->Saml->login();
	}

/**
 * Log a user out.
 *
 * Returns the login action to redirect to. Triggers the logout() method of
 * all the authenticate objects, so they can perform custom logout logic.
 * AuthComponent will remove the session data, so there is no need to do that
 * in an authentication object. Logging out will also renew the session id.
 * This helps mitigate issues with session replays.
 *
 * @return string AuthComponent::$logoutRedirect
 * @see AuthComponent::$logoutRedirect
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html#logging-users-out
 */
	public function logout() {
		return $this->Saml->logout();
	}
	
	
	
	
	
	/**
 * Handle unauthorized access attempt
 *
 * @param Controller $controller A reference to the controller object
 * @return boolean Returns false
 * @throws ForbiddenException
 */
	protected function _unauthorized(Controller $controller) {
		if ($this->unauthorizedRedirect === false) {
			throw new ForbiddenException($this->authError);
		}

		$this->flash($this->authError);
		if ($this->unauthorizedRedirect === true) {
			$default = '/';
			if (!empty($this->loginRedirect)) {
				$default = $this->loginRedirect;
			}
			$url = $controller->referer($default, true);
		} else {
			$url = $this->unauthorizedRedirect;
		}
		$controller->redirect($url, null, true);
		return false;
	}
	



	/**
 * Check whether or not the current user has data in the session, and is considered logged in.
 *
 * @return boolean true if the user is logged in, false otherwise
 */
	public function loggedIn() {		
		$s = $this->Saml->getAttributes();
		return !empty( $s );
	}


}
