<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

/**
 * Allows the Saml plugin to integrate with the CakePHP Authentication library.
 * @author Ben Vidulich
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
 *
 */
class SamlAuthenticate extends BaseAuthenticate
{

    private $saml;

    /**
     * Settings for this object.
     *
     * - `fields` The fields to use to identify a user by.
     * - `userModel` The model name of the User, defaults to User.
     * - `scope` Additional conditions to use when looking up and authenticating users,
     *    i.e. `array('User.is_active' => 1).`
     * - `recursive` The value of the recursive key passed to find(). Defaults to 0.
     * - `contain` Extra models to contain and store in session.
     * - `path` where is SimpleSamlphp folder
     * - `authSource` where is SimpleSamlphp folder
     *
     * @var array
     */
    public $settings = array(
        'fields' => array(
            'username' => 'username',
        ),
        'userModel' => 'User',
        'scope' => array(),
        'recursive' => 0,
        'contain' => null,
        'path' => '',
        'authSource' => 'default-sp',
    );

    /**
     * Initializes a SimpleSAML_Auth_Simple object.
     *
     * @param string $authSource The ID of the authentication source to use. This will
     * override the authentication source set in `app/Config/bootstrap.php`.
     */
    public function __construct(ComponentCollection $collection, array $settings, string $authSource = NULL)
    {
        parent::__construct($collection, $settings);

        // Check the config
        if (Configure::check('Saml.SimpleSamlPath')) {
            $this->settings['path'] = Configure::read('Saml.SimpleSamlPath');
        } else {
            throw new Exception('Parameter Saml.SimpleSamlPath is missing from the configuration file.');
        }

        if (Configure::check('Saml.AuthSource')) {
            $this->settings['authSource'] = Configure::read('Saml.AuthSource');
        }
    }

    /**
     * Authenticate a user using Digest HTTP auth. Will use the configured User model and attempt a
     * login using Digest HTTP auth.
     *
     * @param CakeRequest $request The request to authenticate with.
     * @param CakeResponse $response The response to add headers to.
     * @return mixed Either false on failure, or an array of user data on success.
     */
    public function authenticate(CakeRequest $request, CakeResponse $response)
    {
        // Initialize simpleSAMLphp
        require_once($this->settings['path'] . '/lib/_autoload.php');
        $this->saml = new SimpleSAML_Auth_Simple($this->settings['authSource']);

        if ($this->saml->isAuthenticated()) {
           // return $user = $this->saml->getAttributes();
           
            return $this->_findUser(array('User.username' => 'alevilar'));
        } else {
            return false;
        }
    }

    /**
     * Generates a login action into the server
     * It redirects to simpleSamlh doing the login as configured there
     * 
     */
    public static function login()
    {
        $Path = Configure::read('Saml.SimpleSamlPath');
        $authsurce = Configure::read('Saml.AuthSource');
        require_once($Path . '/lib/_autoload.php');
        $saml = new SimpleSAML_Auth_Simple($authsurce);
        $saml->requireAuth();
    }

    /**
     * Logs the user out.
     */
    public function logout($user)
    {        
        $Path = Configure::read('Saml.SimpleSamlPath');
        $authsurce = Configure::read('Saml.AuthSource');
        require_once($Path . '/lib/_autoload.php');
        $saml = new SimpleSAML_Auth_Simple($authsurce);
        if ($saml->isAuthenticated()) {
            $saml->logout(SimpleSAML_Utilities::selfURLNoQuery());
        }
        return true;
    }

}

?>