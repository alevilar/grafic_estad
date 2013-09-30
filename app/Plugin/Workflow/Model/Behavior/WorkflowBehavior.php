<?php
App::uses('ModelBehavior', 'Model');
/**
* Workflow behavior
*
* @author Juraj Jancuska <jjancuska@gmail.com>
* @copyright (c) 2010 Juraj Jancuska
* @license MIT License - http://www.opensource.org/licenses/mit-license.php
*/
class WorkflowBehavior extends ModelBehavior {
	
	
		public function setup(Model $model, $config = array()) {

		}
		
		
		public function beforeFind(Model $model, $query){
				$model->bindModel(array(
					'belongsTo' => array(
						'State' => array(
							'className' => 'Workflow.State',
						),
					)
				), true);
		}
		
		
		public function beforeSave(Model $Model) {
			if (!isset($Model->data[$Model->alias]['state_id'])) {
				if (empty($Model->data[$Model->alias]['state_id'])){
					unset($Model->data[$Model->alias]['state_id']);
				}
			}
			return true;
		}
}
?>