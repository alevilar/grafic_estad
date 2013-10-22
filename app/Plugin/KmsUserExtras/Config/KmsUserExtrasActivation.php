<?php
/**
 * KmsUserExtras Activation
 *
 * Activation class for KmsUserExtras plugin.
 *
 * @package  Croogo
 */
class KmsUserExtrasActivation {

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
                $CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('KmsUserExtras');
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
                $CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('KmsUserExtras');
		return true;
		
	}
}
