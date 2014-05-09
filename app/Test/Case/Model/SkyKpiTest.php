<?php
App::uses('SkyKpi', 'Model');

/**
 * SkyKpi Test Case
 *
 */
class SkyKpiTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_kpi'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyKpi = ClassRegistry::init('SkyKpi');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyKpi);

		parent::tearDown();
	}

}
