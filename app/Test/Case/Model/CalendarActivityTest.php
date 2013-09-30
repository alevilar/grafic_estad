<?php
App::uses('CalendarActivity', 'Model');

/**
 * CalendarActivity Test Case
 *
 */
class CalendarActivityTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.calendar_activity',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CalendarActivity = ClassRegistry::init('CalendarActivity');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CalendarActivity);

		parent::tearDown();
	}

}
