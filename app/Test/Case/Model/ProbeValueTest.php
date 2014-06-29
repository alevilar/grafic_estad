<?php
App::uses('ProbeValue', 'Model');

/**
 * ProbeValue Test Case
 *
 */
class ProbeValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.probe_value',
		'app.probe',
		'app.probe_data'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProbeValue = ClassRegistry::init('ProbeValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProbeValue);

		parent::tearDown();
	}

}
