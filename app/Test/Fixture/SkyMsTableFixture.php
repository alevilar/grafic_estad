<?php
/**
 * SkyMsTableFixture
 *
 */
class SkyMsTableFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'sky_ms_table';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'site_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'sector_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'carrier_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'datetime' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'om_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'comand_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'retcode' => array('type' => 'integer', 'null' => false, 'default' => null),
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
			'site_id' => 1,
			'sector_id' => 1,
			'carrier_id' => 1,
			'datetime' => '2013-10-01 20:13:50',
			'om_id' => 1,
			'comand_number' => 1,
			'retcode' => 1,
			'created' => 1380669230,
			'updated' => 1380669230
		),
	);

}
