<?php
App::uses('SkyFec', 'Model');

/**
 * SkyFec Test Case
 *
 */
class SkyFecTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_fec'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyFec = ClassRegistry::init('SkyFec');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyFec);

		parent::tearDown();
	}

}
