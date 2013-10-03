<?php
/**
 * SkyLogMstationFixture
 *
 */
class SkyLogMstationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'ms_table_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'mstation_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf16_general_ci', 'charset' => 'utf16'),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'mstation_pwr' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'dl_cinr' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'ul_cinr' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'dl_rssi' => array('type' => 'integer', 'null' => false, 'default' => null),
		'ul_rssi' => array('type' => 'integer', 'null' => false, 'default' => null),
		'dl_fec_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'ul_fec_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'dl_repetitionfatctor' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'ul_repetitionfatctor' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'dl_mimo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'benum' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'nrtpsnum' => array('type' => 'integer', 'null' => false, 'default' => null),
		'rtpsnum' => array('type' => 'integer', 'null' => false, 'default' => null),
		'ertpsnum' => array('type' => 'integer', 'null' => false, 'default' => null),
		'ugsnum' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'ul_per_for_an_ms' => array('type' => 'integer', 'null' => false, 'default' => null),
		'ni_value' => array('type' => 'integer', 'null' => false, 'default' => null),
		'dl_traffic_rate' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'ul_traffic_rate' => array('type' => 'biginteger', 'null' => false, 'default' => null),
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
			'id' => '',
			'ms_table_id' => '',
			'mstation_id' => 'Lorem ipsum dolor sit amet',
			'status_id' => 1,
			'mstation_pwr' => 1,
			'dl_cinr' => 1,
			'ul_cinr' => 1,
			'dl_rssi' => 1,
			'ul_rssi' => 1,
			'dl_fec_id' => 1,
			'ul_fec_id' => 1,
			'dl_repetitionfatctor' => 1,
			'ul_repetitionfatctor' => 1,
			'dl_mimo_id' => 1,
			'benum' => 1,
			'nrtpsnum' => 1,
			'rtpsnum' => 1,
			'ertpsnum' => 1,
			'ugsnum' => 1,
			'ul_per_for_an_ms' => 1,
			'ni_value' => 1,
			'dl_traffic_rate' => '',
			'ul_traffic_rate' => '',
			'created' => 1380669172,
			'updated' => 1380669172
		),
	);

}
