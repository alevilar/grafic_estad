<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Ale Vilar <alevilar@gmail.com>
 */
class SkpiActivation {

     

        /**
         * Plugin name
         *
         * @var string
         */
        public $pluginName = 'Skpi';

    

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
            $controller->Setting->write('Sky.msRotacionSitios', 6000, array(
                    'editable' => 1, 'description' => __('Cantidad de Milisegundos que tarda en rotar de un sitio a otro en la vista de Kpi´s', true))
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


        }
}
?>