<?php
App::uses('SkyCarrier', 'Model');

/**
 * SkyCarrier Test Case
 *
 */
class SkyCarrierTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_carrier',
		'app.sector'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyCarrier = ClassRegistry::init('SkyCarrier');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyCarrier);

		parent::tearDown();
	}

}
