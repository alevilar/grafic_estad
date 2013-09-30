<?php
App::uses('StateTable', 'Model');

/**
 * StateTable Test Case
 *
 */
class StateTableTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.state_table',
		'app.role',
		'app.type',
		'app.state'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->StateTable = ClassRegistry::init('StateTable');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->StateTable);

		parent::tearDown();
	}

}
