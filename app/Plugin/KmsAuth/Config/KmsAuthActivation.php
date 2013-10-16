<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Ale Vilar <alevilar@gmail.com>
 */
class KmsAuthActivation {

     

        /**
         * Plugin name
         *
         * @var string
         */
        public $pluginName = 'KmsAuth';

    

        /**
         * Before onActivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeActivation(&$controller) {
                return true;
        }

        /**
         * Activation of plugin,
         * called only if beforeActivation return true
         *
         * @param object $controller
         * @return void
         */
        public function onActivation(&$controller) {
                $controller->Setting->write('Saml.SimpleSamlPath', ROOT . DS . APP_DIR . DS . WEBROOT_DIR. DS . 'simplesamlphp', array(
                    'editable' => 1, 'description' => __('path where is simple saml installed', true))
                );
                
                $controller->Setting->write('Saml.AuthSource', 'default-sp', array(
                    'editable' => 1, 'description' => __('SimpleSaml Auth Source ("default-sp" as default)', true))
                );
        }

        /**
         * Before onDeactivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeDeactivation(&$controller) {
                return true;

        }

        /**
         * Deactivation of plugin,
         * called only if beforeActivation return true
         *
         * @param object $controller
         * @return void
         */
        public function onDeactivation(&$controller) {

                $controller->Setting->deleteKey('Workflow');

        }
}
?>