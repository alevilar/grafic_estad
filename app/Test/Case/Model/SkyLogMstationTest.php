<?php
App::uses('SkyLogMstation', 'Model');

/**
 * SkyLogMstation Test Case
 *
 */
class SkyLogMstationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_log_mstation',
		'app.ms_table',
		'app.status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyLogMstation = ClassRegistry::init('SkyLogMstation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyLogMstation);

		parent::tearDown();
	}

}
