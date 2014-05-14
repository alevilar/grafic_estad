<?php
/**
 * SkyKpiDailyValueFixture
 *
 */
class SkyKpiDailyValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'kpi_data_day_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'kpi_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'value' => array('type' => 'float', 'null' => false, 'default' => null),
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
			'kpi_data_day_id' => 1,
			'kpi_id' => 'Lorem ipsum dolor sit amet',
			'value' => 1,
			'created' => '2014-05-13 21:27:27'
		),
	);

}
