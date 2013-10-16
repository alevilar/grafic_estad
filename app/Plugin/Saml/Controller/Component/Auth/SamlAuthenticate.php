<?php 

App::uses('Component', 'Controller');

/**
 * Allows the Saml plugin to integrate with the CakePHP Authentication library.
 * @author Ben Vidulich
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
 *
*/
class SamlAuthenticate extends BaseAuthenticate {
	/**
        * Settings for this object.
        *
        * - `fields` The fields to use to identify a user by.
        * - `userModel` The model name of the User, defaults to User.
        * - `scope` Additional conditions to use when looking up and authenticating users,
        *    i.e. `array('User.is_active' => 1).`
        * - `recursive` The value of the recursive key passed to find(). Defaults to 0.
        * - `contain` Extra models to contain and store in session.
        *
        * @var array
        */
               public $settings = array(
                       'fields' => array(
                               'username' => 'username',
                               'password' => 'password'
                       ),
                       'userModel' => 'User',
                       'scope' => array(),
                       'recursive' => 0,
                       'contain' => null,
               );
               
        
      
        
        
        /**
        * Authenticate a user using Digest HTTP auth. Will use the configured User model and attempt a
        * login using Digest HTTP auth.
        *
        * @param CakeRequest $request The request to authenticate with.
        * @param CakeResponse $response The response to add headers to.
        * @return mixed Either false on failure, or an array of user data on success.
        */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		$user = $this->getUser($request);

		if (empty($user)) {
			$response->header($this->loginHeaders());
			$response->statusCode(401);
			$response->send();
			return false;
		}
		return $user;
	}
        
        
        
        
        /**
         * Get a user based on information in the request. Used by cookie-less auth for stateless clients.
         *
         * @param CakeRequest $request Request object.
         * @return mixed Either false or an array of user information
         */
	public function getUser(CakeRequest $request) {
		$digest = $this->_getDigest();
		if (empty($digest)) {
			return false;
		}
		$user = $this->_findUser($digest['username']);
		if (empty($user)) {
			return false;
		}
		$password = $user[$this->settings['fields']['password']];
		unset($user[$this->settings['fields']['password']]);
		if ($digest['response'] === $this->generateResponseHash($digest, $password)) {
			return $user;
		}
		return false;
	}
        
        

	/**
	 * Get user information.  
	 *
	 * @return mixed Either false or an array of user information
	 */
	public function getUser() {
		return $this->Saml->getAttributes();
	}
	
	/**
	 * Logs the user out.
	 */
	public function logout() {
	}
}

?>