<?php
/**
 * SkyFecFixture
 *
 */
class SkyFecFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'unique'),
		'modulation' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'created' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'updated' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'number' => array('column' => 'number', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf16', 'collate' => 'utf16_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'number' => 1,
			'modulation' => 'Lorem ipsum do',
			'created' => 1380669051,
			'updated' => 1380669051
		),
	);

}
