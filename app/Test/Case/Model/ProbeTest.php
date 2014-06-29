<?php
App::uses('Probe', 'Model');

/**
 * Probe Test Case
 *
 */
class ProbeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		$this->Probe = ClassRegistry::init('Probe');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Probe);

		parent::tearDown();
	}

}
