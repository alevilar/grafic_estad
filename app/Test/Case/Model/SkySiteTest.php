<?php
App::uses('SkySite', 'Model');

/**
 * SkySite Test Case
 *
 */
class SkySiteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_site'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkySite = ClassRegistry::init('SkySite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkySite);

		parent::tearDown();
	}

}
