<?php
/**
 * StateTableFixture
 *
 */
class StateTableFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'state_from' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'state_to' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'role_id' => 1,
			'type_id' => 1,
			'state_from' => 1,
			'state_to' => 1,
			'updated' => '2013-06-28 22:43:08',
			'created' => '2013-06-28 22:43:08'
		),
	);

}
