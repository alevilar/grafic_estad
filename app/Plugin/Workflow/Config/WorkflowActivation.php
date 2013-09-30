<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Ale Vilar <alevilar@gmail.com>
 */
class WorkflowActivation {

     

        /**
         * Plugin name
         *
         * @var string
         */
        public $pluginName = 'Workflow';

    

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
                $controller->Setting->write('Workflow.defaultStateId', '1', array(
                    'editable' => 1, 'description' => __('When you add new Nodes only will be shown this state as the "Initial State" in the Workflow tab', true))
                );
                
                $CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('Workflow');
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
                
                $CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('Workflow');
		return true;

        }
}
?>