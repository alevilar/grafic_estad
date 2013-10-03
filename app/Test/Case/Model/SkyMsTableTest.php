<?php
App::uses('SkyMsTable', 'Model');

/**
 * SkyMsTable Test Case
 *
 */
class SkyMsTableTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sky_ms_table',
		'app.site',
		'app.sector',
		'app.carrier'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkyMsTable = ClassRegistry::init('SkyMsTable');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkyMsTable);

		parent::tearDown();
	}

}
