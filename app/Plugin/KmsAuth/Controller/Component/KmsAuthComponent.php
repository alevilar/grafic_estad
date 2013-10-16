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
 * Main execution method. Handles redirecting of invalid users, and processing
 * of login form data.
 *
 * @param Controller $controller A reference to the instantiating controller object
 * @return boolean
 */
	public function startup(Controller $controller) {
            $controller->Auth->authenticate[] = 'KmsAuth.Saml';
	}

}
