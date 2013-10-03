<?php
App::uses('SkyStatus', 'Model');

/**
 * SkyStatus Test Case
 *
 */
class SkyStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyStatus = ClassRegistry::init('SkyStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyStatus);

		parent::tearDown();
	}

}
