<?php
/**
 * SkyKpiFixture
 *
 */
class SkyKpiFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'field_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'string_format' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'sql_threshold_warning' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'sql_threshold_danger' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'field_name' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'string_format' => 'Lorem ipsum dolor sit amet',
			'sql_threshold_warning' => 'Lorem ipsum dolor sit amet',
			'sql_threshold_danger' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-05-09 18:54:49'
		),
	);

}
