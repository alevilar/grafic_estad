<?php
class InstallKpis extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = 'Install KPIs table';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'sky_date_kpis' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),

					'carrier_id' => array('type' => 'integer', 'null' => false, 'default' => null),

					'date' => array('type' => 'date', 'null' => false, 'default' => null),


					'max_dl' => array('type' => 'integer', 'null' => false, 'default' => null),
					'max_ul' => array('type' => 'integer', 'null' => false, 'default' => null),

					'initial_ntwk_entry_success_rate' => array('type' => 'float', 'null' => false, 'default' => null),
					'success_rate_of_ntwk_re_entry_idle_mode' => array('type' => 'float', 'null' => false, 'default' => null),
					'radio_dropt_rate' => array('type' => 'float', 'null' => false, 'default' => null),
					'network_disconnection_ratio' => array('type' => 'float', 'null' => false, 'default' => null),
					'carrier_dl_be_avg_traffic_rate' => array('type' => 'integer', 'null' => false, 'default' => null),
					'avg_ntwk_entry_delay_users' => array('type' => 'integer', 'null' => false, 'default' => null),
					'ul_per' => array('type' => 'float', 'null' => false, 'default' => null),
					'dl_per' => array('type' => 'float', 'null' => false, 'default' => null),
					'avg_ul_slot_coding_eff' => array('type' => 'integer', 'null' => false, 'default' => null),
					'avg_dl_slot_coding_eff' => array('type' => 'integer', 'null' => false, 'default' => null),
					'num_actived_users' => array('type' => 'integer', 'null' => false, 'default' => null),
					'access_success_rate' => array('type' => 'float', 'null' => false, 'default' => null),
					'radio_access_rate' => array('type' => 'float', 'null' => false, 'default' => null),


					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				)
			)
		),
		'down' => array(
			'drop_table' => array(
				'sky_date_kpis'
			)
		)
	);

/**
 * Records to be migrated
 *
 * @var array
 * @access public
 */
	public $records = array();

/**
 * Mappings to the records
 *
 * @var array
 * @access public
 */
	public $mappings = array();

}