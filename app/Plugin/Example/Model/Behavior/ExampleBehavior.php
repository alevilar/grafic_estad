<?php
App::uses('ModelBehavior', 'Model');

/**
 * Example Behavior
 *
 * PHP version 5
 *
 * @category Behavior
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class ExampleBehavior extends ModelBehavior {

/**
 * Setup
 *
 * @param Model $model
 * @param array $config
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		if (is_string($config)) {
			$config = array($config);
		}

		$this->settings[$model->alias] = $config;
	}


	public function beforeFind($queryData) {
		debug($this->name);die;
	}
}
