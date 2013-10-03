<?php
App::uses('SkyMimo', 'Model');

/**
 * SkyMimo Test Case
 *
 */
class SkyMimoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_mimo'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyMimo = ClassRegistry::init('SkyMimo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyMimo);

		parent::tearDown();
	}

}
