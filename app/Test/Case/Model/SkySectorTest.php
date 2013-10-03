<?php
App::uses('SkySector', 'Model');

/**
 * SkySector Test Case
 *
 */
class SkySectorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_sector',
		'app.site'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkySector = ClassRegistry::init('SkySector');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkySector);

		parent::tearDown();
	}

}
