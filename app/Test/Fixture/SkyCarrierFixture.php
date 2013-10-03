<?php
/**
 * SkyCarrierFixture
 *
 */
class SkyCarrierFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 24, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'sector_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'updated' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'name' => 'Lorem ipsum dolor sit ',
			'sector_id' => 1,
			'created' => 1380666365,
			'updated' => 1380666365
		),
	);

}
