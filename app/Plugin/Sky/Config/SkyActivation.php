<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Ale Vilar <alevilar@gmail.com>
 */
class SkyActivation {

     

        /**
         * Plugin name
         *
         * @var string
         */
        public $pluginName = 'Sky';

    

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
                $controller->Setting->write('Sky.tmpdir', TMP  . 'sky', array(
                    'editable' => 1, 'description' => __('path where files will be to migrate', true))
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

                $controller->Setting->deleteKey('Sky');

        }
}
?>