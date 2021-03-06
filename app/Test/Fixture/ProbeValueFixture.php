<?php
/**
 * ProbeValueFixture
 *
 */
class ProbeValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'probe_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'dl' => array('type' => 'float', 'null' => false, 'default' => null),
		'ul' => array('type' => 'float', 'null' => false, 'default' => null),
		'date_time' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'probe_id' => 1,
			'dl' => 1,
			'ul' => 1,
			'date_time' => '2014-06-25 12:31:01'
		),
	);

}
