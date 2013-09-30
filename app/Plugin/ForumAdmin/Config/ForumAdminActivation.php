<?php
/**
 * Kms Activation
 *
 * Activation class for Example plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
define('ADMIN_PLUGIN', dirname(__DIR__) . '/');
// User model
if (!defined('USER_MODEL')) {
	define('USER_MODEL', 'User');
}
 
 
class ForumAdminActivation {

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeActivation(&$controller) {
		return true;
	}

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onActivation(&$controller) {
		$controller->Setting->write('Admin.aliases.administrator', 'Role-admin', array(
                    'editable' => 1, 'description' => 'Admin role alias in ARO')
                );
                
             

                
	}

/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeDeactivation(&$controller) {
		return true;
	}

/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onDeactivation(&$controller) {
		// $controller->Setting->deleteKey('Admin');
		
	}
}
