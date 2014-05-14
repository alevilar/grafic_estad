<?php
App::uses('SkyKpiDailyValue', 'Model');

/**
 * SkyKpiDailyValue Test Case
 *
 */
class SkyKpiDailyValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_kpi_daily_value',
		'app.kpi_data_day',
		'app.kpi'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyKpiDailyValue = ClassRegistry::init('SkyKpiDailyValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyKpiDailyValue);

		parent::tearDown();
	}

}
