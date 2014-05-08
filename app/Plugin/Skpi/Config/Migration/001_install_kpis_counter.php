<?php
class InstallKpiCounter extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = 'Install KPIs counters';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
                                'sky_kpi_counters' => array(                                 
					'id' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null),
                                        'name' => array('type' => 'string', 'length' => 64, 'null' => false, 'default' => null),
                                        'graph' => array('type' => 'boolean', 'null' => false, 'default' => true),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				),
                                'sky_kpis' => array(					
					'id' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null),
                                        'name' => array('type' => 'string', 'length' => 64, 'null' => false, 'default' => null),                                        
                                        'sql_threshold_warning' => array('type' => 'string', 'length' => 64, 'null' => true, 'default' => null),
                                        'sql_threshold_danger' => array('type' => 'string', 'length' => 64, 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				),
                                'sky_kpi_hourly_counters' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                                        'carrier_id' => array('type' => 'integer', 'null' => false, 'default' => null),
                                        'kpi_counter_id' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null),
                                        'value' => array('type' => 'float', 'null' => false),
                                        'ml_datetime' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				),
                                'sky_kpi_data_days' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                                        'carrier_id' => array('type' => 'integer', 'null' => false, 'default' => null),
                                        'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				), 
                                'sky_kpi_daily_values' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                                        'kpi_data_day_id' => array('type' => 'integer', 'null' => false, 'default' => null),
                                        'kpi_id' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null),
                                        'value' => array('type' => 'float', 'null' => false),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
                                ),   
                            ),
                        
		),
		'down' => array(
			'drop_table' => array(
				'sky_kpi_counters',
                                'sky_kpis',
                                'sky_date_kpis',
                                'sky_data_counters',
			)
		)
	);


         public function after($direction) {
            $KpiCounter = ClassRegistry::init('Sky.KpiCounter');
            $Kpi = ClassRegistry::init('Sky.Kpi');
            if ($direction === 'up') {
                $kpiCounters['KpiCounter'] = array(
                    array(
                        'id'   => 'ni',
                        'name' =>'Ni',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'interference_density_based_on_ni',
                        'name' => 'interference_density_based_on_ni',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'interference_intensity_based_on_ni',
                        'name' => 'interference_intensity_based_on_ni',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'maximum_number_of_online_users',
                        'name' =>'maximum_number_of_online_users',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_of_network_entry_latency_from_10s_to_20s',
                        'name' => 'times_of_network_entry_latency_from_10s_to_20s',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_of_network_entry_latency_from_3s_to_6s',
                        'name' => 'times_of_network_entry_latency_from_3s_to_6s',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_of_network_entry_latency_from_6s_to_10s',
                        'name' => 'times_of_network_entry_latency_from_6s_to_10s',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'times_of_network_entry_latency_longer_than_20s',
                        'name' => 'times_of_network_entry_latency_longer_than_20s',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'times_of_network_entry_latency_within_3s',
                        'name' => 'times_of_network_entry_latency_within_3s',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'network_disconnection_ratio',
                        'name' => 'network_disconnection_ratio',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'number_of_users_at_end_of_measurement_period',
                        'name' => 'number_of_users_at_end_of_measurement_period',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'times_of_deregistration_due_to_air_link_failure',
                        'name' => 'times_of_deregistration_due_to_air_link_failure',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'times_of_deregistration_initiated_by_gw',
                        'name' => 'times_of_deregistration_initiated_by_gw',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'times_of_deregistration_initiated_by_ms',
                        'name' => 'times_of_deregistration_initiated_by_ms',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'times_of_ms_disconnection_from_network',
                        'name' => 'times_of_ms_disconnection_from_network',
                        'graph' => true,
                    ),
                    array(
                        'id'   =>  'average_tx_power_of_subcarriers_of_users_on_carrier',
                        'name' =>  'average_tx_power_of_subcarriers_of_users_on_carrier',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'dl_broadcast_traffic',
                        'name' => 'dl_broadcast_traffic',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'dl_all_zone_occupancy_rate',
                        'name' => 'dl_all_zone_occupancy_rate',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'ul_all_zone_occupancy_rate',
                        'name' => 'ul_all_zone_occupancy_rate',
                        'graph' => true,
                    ),array(
                        'id'   => 'average_dl_slot_coding_efficiency',
                        'name' => 'average_dl_slot_coding_efficiency',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'average_number_of_mimo-a_users',
                        'name' => 'average_number_of_mimo-a_users',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'average_number_of_mimo-b_users',
                        'name' => 'average_number_of_mimo-b_users',
                        'graph' => true,
                    ),
                   array(
                        'id'   => 'average_number_of_online_users',
                        'name' => 'average_number_of_online_users',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'average_ul_slot_coding_efficiency',
                        'name' => 'average_ul_slot_coding_efficiency',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'number_of_burst_filling_failures',
                        'name' => 'number_of_burst_filling_failures',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'access_success_rate',
                        'name' => 'access_success_rate',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'radio_access_success_rate',
                        'name' => 'radio_access_success_rate',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'initial_network_entry_success_rate',
                        'name' => 'initial_network_entry_success_rate',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'radio_drop_rate',
                        'name' => 'radio_drop_rate',
                        'graph' => true,
                    ),array(
                        'id'   => 'network_disconnection_ratio',
                        'name' => 'network_disconnection_ratio',
                        'graph' => true,
                    ),
                    array(
                        'id'   => 'dl_per',
                        'name'  => 'dl_per',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'ul_per',
                        'name'  => 'ul_per',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_is_lower_than_0_db',
                        'name'  => 'times_when_dl_cinr_is_lower_than_0_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_ranges_from_1_db_to_4_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_1_db_to_4_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_ranges_from_5_db_to_8_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_5_db_to_8_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_ranges_from_9_db_to_12_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_9_db_to_12_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_ranges_from_13_db_to_16_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_13_db_to_16_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_ranges_from_17_db_to_20_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_17_db_to_20_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_ranges_from_21_db_to_26_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_21_db_to_26_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_cinr_is_higher_than_27_db',
                        'name'  => 'times_when_dl_cinr_is_higher_than_27_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_rssi_ranges_from_89_dbm_to_80_dbm',
                        'name'  => 'times_when_dl_rssi_ranges_from_89_dbm_to_80_dbm',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_dl_rssi_is_not_higher_than_90_dbm',
                        'name'  => 'times_when_dl_rssi_is_not_higher_than_90_dbm',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_is_less_than_0_db',
                        'name'  => 'times_when_ul_cinr_is_less_than_0_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_ranges_from_1_db_to_4_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_1_db_to_4_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_ranges_from_5_db_to_8_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_5_db_to_8_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_ranges_from_9_db_to_12_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_9_db_to_12_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_ranges_from_13_db_to_16_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_13_db_to_16_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_ranges_from_17_db_to_20_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_17_db_to_20_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_ranges_from_21_db_to_26_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_21_db_to_26_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_cinr_is_higher_than_27_db',
                        'name'  => 'times_when_ul_cinr_is_higher_than_27_db',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_rssi_ranges_from_89_dbm_to_80_dbm',
                        'name'  => 'times_when_ul_rssi_ranges_from_89_dbm_to_80_dbm',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'times_when_ul_rssi_is_not_higher_than_90_dbm',
                        'name'  => 'times_when_ul_rssi_is_not_higher_than_90_dbm',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'transmit_power_in_channel_1',
                        'name'  => 'transmit_power_in_channel_1',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'transmit_power_in_channel_2',
                        'name'  => 'transmit_power_in_channel_2',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'transmit_power_in_channel_3',
                        'name'  => 'transmit_power_in_channel_3',
                        'graph' => true,
                    ),
                    array(
                        'id'    => 'transmit_power_in_channel_4',
                        'name'  => 'transmit_power_in_channel_4',
                        'graph' => true,
                    ),
                );
                                
                foreach ( $kpiCounters as $key=>$data ) {
                    $KpiCounter->create();
                    $insData = array(
                        $key => $data
                    );
                    if ($KpiCounter->save($insData)) {
                        $this->callback->out('KpiCounter table has been initialized');
                    } 
                }
                
                
                
                
                $kpiFields['Kpi'] = array(		
                    array(
                        'id'    => 'max_dl',
                        'name'  => 'Máximo tráfico DL',
                    ),
                    array(
                        'id'    => 'max_ul',
                        'name'  => 'Máximo tráfico UL',
                    ),
                    array(
                        'id'    => 'initial_ntwk_entry_success_rate',
                        'name'  => 'Initial Network Entry Success Rate',
                        'sql_threshold_warning' => '? >= 70 && ? < 80',
                        'sql_threshold_danger' => '? < 70',
                    ),
                    array(
                        'id'    => 'success_rate_of_ntwk_re_entry_idle_mode',
                        'name'  => 'Success Rate of Network Re-Entry in Idle Mode',
                        'sql_threshold_warning' => '? >= 85 && ? < 95',
                        'sql_threshold_danger' => '? < 85',
                    ),
                    array(
                        'id'    => 'radio_dropt_rate',
                        'name'  => 'Radio Drop Rate',
                        'sql_threshold_warning' => '? > 2 && ? <= 5',
                        'sql_threshold_danger' => '? > 5',
                    ),
                    array(
                        'id'    => 'network_disconnection_ratio',
                        'name'  => 'Network Disconnection Ratio',
                        'sql_threshold_warning' => '? > 3 && ? <= 6',
                        'sql_threshold_danger' => '? > 6',
                    ),
                    array(                        
                        'id'    => 'carrier_dl_be_avg_traffic_rate',
                        'name'  => 'Carrier DL BE Average Traffic Rate (All Day)',
                    ),
                    array(
                        'id'    => 'avg_ntwk_entry_delay_users',
                        'name'  => 'Average Network Entry Delay of Users',
                        'sql_threshold_warning' => '? > 3000 && ? <= 10000',
                        'sql_threshold_danger' => '? > 10000',
                    ),
                    array(
                        'id'    => 'ul_per',
                        'name'  => 'UL PER',
                        'sql_threshold_warning' => '? > 1 && ? <= 3',
                        'sql_threshold_danger' => '? > 3',
                    ),
                    array(
                        'id'    => 'dl_per',
                        'name'  => 'DL PER',
                        'sql_threshold_warning' => '? > 1 && ? <= 2',
                        'sql_threshold_danger' => '? > 2',
                    ),
                    array(
                        'id'    => 'avg_ul_slot_coding_eff',
                        'name'  => 'Average UL Slot Coding Efficiency',
                    ),
                    array(
                        'id'    => 'avg_dl_slot_coding_eff',
                        'name'  => 'Average DL Slot Coding Efficiency',
                    ),
                    array(
                        'id'    => 'num_actived_users',
                        'name'  => 'Number of Activated Users (WASN9770)',
                    ),
                    array(
                        'id'    => 'access_success_rate',
                        'name'  => 'Access Success Rate',
                        'sql_threshold_warning' => '? >= 80 && ? <= 90',
                        'sql_threshold_danger' => '? < 80',
                    ),
                    array(
                        'id'    => 'radio_access_rate',
                        'name'  => 'Radio Access Rate',
                        'sql_threshold_warning' => '? >= 90 && ? <= 97',
                        'sql_threshold_danger' => '? < 90',
                    ),		
		);
                
                foreach ( $kpiFields as $key=>$data ) {
                    $Kpi->create();
                    $insData = array(
                        $key => $data
                    );
                    if ($Kpi->save($insData)) {
                        $this->callback->out('Kpi table has been initialized');
                    } 
                }
                
            } elseif ($direction === 'down') {
                // do more work here
            }
            return true;
        }


}