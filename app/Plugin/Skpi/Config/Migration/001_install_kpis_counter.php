<?php
class Install1123KpiCounter extends CakeMigration {

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
                        'drop_table' => array(
				'sky_date_kpis',                                
			),
			'create_table' => array(
                                'sky_kpi_counters' => array(      
                                        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'field_name' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null, 'unique'=>1),
                                        'name' => array('type' => 'string', 'length' => 64, 'null' => false, 'default' => null),
                                        'string_format' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => ''),
                                        'graph' => array('type' => 'boolean', 'null' => false, 'default' => true),
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
                                'sky_kpis' => array(					
                                        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'field_name' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null, 'unique'=>1),
                                        'name' => array('type' => 'string', 'length' => 64, 'null' => false, 'default' => null),                  
                                        'string_format' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => ''),
                                        'sql_threshold_warning' => array('type' => 'string', 'length' => 64, 'null' => true, 'default' => null),
                                        'sql_threshold_danger' => array('type' => 'string', 'length' => 64, 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				),
                                'sky_kpi_data_days' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                                        'carrier_id' => array('type' => 'integer', 'null' => false, 'default' => null),
                                        'ml_date' => array('type' => 'date', 'null' => true, 'default' => null),
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
                        'field_name'   => 'ni',
                        'name' =>'Ni',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'interference_density_based_on_ni',
                        'name' => 'interference_density_based_on_ni',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'interference_intensity_based_on_ni',
                        'name' => 'interference_intensity_based_on_ni',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'maximum_number_of_online_users',
                        'name' =>'maximum_number_of_online_users',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_of_network_entry_latency_from_10s_to_20s',
                        'name' => 'times_of_network_entry_latency_from_10s_to_20s',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_of_network_entry_latency_from_3s_to_6s',
                        'name' => 'times_of_network_entry_latency_from_3s_to_6s',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_of_network_entry_latency_from_6s_to_10s',
                        'name' => 'times_of_network_entry_latency_from_6s_to_10s',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'times_of_network_entry_latency_longer_than_20s',
                        'name' => 'times_of_network_entry_latency_longer_than_20s',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'times_of_network_entry_latency_within_3s',
                        'name' => 'times_of_network_entry_latency_within_3s',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'network_disconnection_ratio',
                        'name' => 'network_disconnection_ratio',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'number_of_users_at_end_of_measurement_period',
                        'name' => 'number_of_users_at_end_of_measurement_period',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'times_of_deregistration_due_to_air_link_failure',
                        'name' => 'times_of_deregistration_due_to_air_link_failure',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'times_of_deregistration_initiated_by_gw',
                        'name' => 'times_of_deregistration_initiated_by_gw',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'times_of_deregistration_initiated_by_ms',
                        'name' => 'times_of_deregistration_initiated_by_ms',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'times_of_ms_disconnection_from_network',
                        'name' => 'times_of_ms_disconnection_from_network',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   =>  'average_tx_power_of_subcarriers_of_users_on_carrier',
                        'name' =>  'average_tx_power_of_subcarriers_of_users_on_carrier',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'dl_broadcast_traffic',
                        'name' => 'dl_broadcast_traffic',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'dl_all_zone_occupancy_rate',
                        'name' => 'dl_all_zone_occupancy_rate',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'ul_all_zone_occupancy_rate',
                        'name' => 'ul_all_zone_occupancy_rate',
                        'graph' => true,
                    ),array(
                        'field_name'   => 'average_dl_slot_coding_efficiency',
                        'name' => 'average_dl_slot_coding_efficiency',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'average_number_of_mimo-a_users',
                        'name' => 'average_number_of_mimo-a_users',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'average_number_of_mimo-b_users',
                        'name' => 'average_number_of_mimo-b_users',
                        'graph' => true,
                    ),
                   array(
                        'field_name'   => 'average_number_of_online_users',
                        'name' => 'average_number_of_online_users',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'average_ul_slot_coding_efficiency',
                        'name' => 'average_ul_slot_coding_efficiency',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'number_of_burst_filling_failures',
                        'name' => 'number_of_burst_filling_failures',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'access_success_rate',
                        'name' => 'access_success_rate',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'radio_access_success_rate',
                        'name' => 'radio_access_success_rate',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'initial_network_entry_success_rate',
                        'name' => 'initial_network_entry_success_rate',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'radio_drop_rate',
                        'name' => 'radio_drop_rate',
                        'graph' => true,
                    ),array(
                        'field_name'   => 'network_disconnection_ratio',
                        'name' => 'network_disconnection_ratio',
                        'graph' => true,
                    ),
                    array(
                        'field_name'   => 'dl_per',
                        'name'  => 'dl_per',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'ul_per',
                        'name'  => 'ul_per',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_is_lower_than_0_db',
                        'name'  => 'times_when_dl_cinr_is_lower_than_0_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_ranges_from_1_db_to_4_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_1_db_to_4_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_ranges_from_5_db_to_8_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_5_db_to_8_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_ranges_from_9_db_to_12_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_9_db_to_12_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_ranges_from_13_db_to_16_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_13_db_to_16_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_ranges_from_17_db_to_20_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_17_db_to_20_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_ranges_from_21_db_to_26_db',
                        'name'  => 'times_when_dl_cinr_ranges_from_21_db_to_26_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_cinr_is_higher_than_27_db',
                        'name'  => 'times_when_dl_cinr_is_higher_than_27_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_rssi_ranges_from_89_dbm_to_80_dbm',
                        'name'  => 'times_when_dl_rssi_ranges_from_89_dbm_to_80_dbm',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_dl_rssi_is_not_higher_than_90_dbm',
                        'name'  => 'times_when_dl_rssi_is_not_higher_than_90_dbm',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_is_less_than_0_db',
                        'name'  => 'times_when_ul_cinr_is_less_than_0_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_ranges_from_1_db_to_4_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_1_db_to_4_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_ranges_from_5_db_to_8_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_5_db_to_8_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_ranges_from_9_db_to_12_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_9_db_to_12_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_ranges_from_13_db_to_16_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_13_db_to_16_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_ranges_from_17_db_to_20_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_17_db_to_20_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_ranges_from_21_db_to_26_db',
                        'name'  => 'times_when_ul_cinr_ranges_from_21_db_to_26_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_cinr_is_higher_than_27_db',
                        'name'  => 'times_when_ul_cinr_is_higher_than_27_db',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_rssi_ranges_from_89_dbm_to_80_dbm',
                        'name'  => 'times_when_ul_rssi_ranges_from_89_dbm_to_80_dbm',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'times_when_ul_rssi_is_not_higher_than_90_dbm',
                        'name'  => 'times_when_ul_rssi_is_not_higher_than_90_dbm',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'transmit_power_in_channel_1',
                        'name'  => 'transmit_power_in_channel_1',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'transmit_power_in_channel_2',
                        'name'  => 'transmit_power_in_channel_2',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'transmit_power_in_channel_3',
                        'name'  => 'transmit_power_in_channel_3',
                        'graph' => true,
                    ),
                    array(
                        'field_name'    => 'transmit_power_in_channel_4',
                        'name'  => 'transmit_power_in_channel_4',
                        'graph' => true,
                    ),
                );
                                
                foreach ( $kpiCounters as $key=>$data ) {                                      
                    foreach ($data as $ds) {
                        $KpiCounter->create();
                        $insData = array(
                            $key => $ds
                        );
                        if (!$KpiCounter->save($insData)) {
                            throw new CakeException('KpiCounter table has been initialized');                            
                        }
                    }
                }
                
                
                $kpiFields['Kpi'] = array(		
                    array(
                        'field_name'    => 'max_dl',
                        'name'  => 'Máximo tráfico DL',
                        'string_format' => '%sKbit/s',
                    ),
                    array(
                        'field_name'    => 'max_ul',
                        'name'  => 'Máximo tráfico UL',
                        'string_format' => '%sKbit/s',
                    ),
                    array(
                        'field_name'    => 'initial_ntwk_entry_success_rate',
                        'name'  => 'Initial Network Entry Success Rate',
                        'sql_threshold_warning' => '? >= 70 && ? < 80',
                        'sql_threshold_danger' => '? < 70',
                    ),
                    array(
                        'field_name'    => 'success_rate_of_ntwk_re_entry_idle_mode',
                        'name'  => 'Success Rate of Network Re-Entry in Idle Mode',
                        'sql_threshold_warning' => '? >= 85 && ? < 95',
                        'sql_threshold_danger' => '? < 85',
                    ),
                    array(
                        'field_name'    => 'radio_dropt_rate',
                        'name'  => 'Radio Drop Rate',
                        'sql_threshold_warning' => '? > 2 && ? <= 5',
                        'sql_threshold_danger' => '? > 5',
                    ),
                    array(
                        'field_name'    => 'network_disconnection_ratio',
                        'name'  => 'Network Disconnection Ratio',
                        'sql_threshold_warning' => '? > 3 && ? <= 6',
                        'sql_threshold_danger' => '? > 6',
                    ),
                    array(                        
                        'field_name'    => 'carrier_dl_be_avg_traffic_rate',
                        'name'  => 'Carrier DL BE Average Traffic Rate (All Day)',
                    ),
                    array(
                        'field_name'    => 'avg_ntwk_entry_delay_users',
                        'name'  => 'Average Network Entry Delay of Users',
                        'sql_threshold_warning' => '? > 3000 && ? <= 10000',
                        'sql_threshold_danger' => '? > 10000',
                    ),
                    array(
                        'field_name'    => 'ul_per',
                        'name'  => 'UL PER',
                        'sql_threshold_warning' => '? > 1 && ? <= 3',
                        'sql_threshold_danger' => '? > 3',
                    ),
                    array(
                        'field_name'    => 'dl_per',
                        'name'  => 'DL PER',
                        'sql_threshold_warning' => '? > 1 && ? <= 2',
                        'sql_threshold_danger' => '? > 2',
                    ),
                    array(
                        'field_name'    => 'avg_ul_slot_coding_eff',
                        'name'  => 'Average UL Slot Coding Efficiency',
                    ),
                    array(
                        'field_name'    => 'avg_dl_slot_coding_eff',
                        'name'  => 'Average DL Slot Coding Efficiency',
                    ),
                    array(
                        'field_name'    => 'num_actived_users',
                        'name'  => 'Number of Activated Users (WASN9770)',
                    ),
                    array(
                        'field_name'    => 'access_success_rate',
                        'name'  => 'Access Success Rate',
                        'sql_threshold_warning' => '? >= 80 && ? <= 90',
                        'sql_threshold_danger' => '? < 80',
                    ),
                    array(
                        'field_name'    => 'radio_access_rate',
                        'name'  => 'Radio Access Rate',
                        'sql_threshold_warning' => '? >= 90 && ? <= 97',
                        'sql_threshold_danger' => '? < 90',
                    ),		
		);
                
                
                foreach ( $kpiFields as $key=>$data ) {                                      
                    foreach ($data as $ds) {
                        $Kpi->create();
                        $insData = array(
                            $key => $ds
                        );                        
                        if (!$Kpi->save($insData)) {
                            throw new CakeException('Kpi table has been initialized');                                
                        }
                    }
                }
                
                
                $dataDay = array(
                    array(
                        'carrier_id' => 1,
                        'ml_date' => '2014-05-01'
                    ),
                    array(
                        'carrier_id' => 1,
                        'ml_date' => '2014-05-02'
                    ),
                    array(
                        'carrier_id' => 1,
                        'ml_date' => '2014-05-03'
                    ),
                    array(
                        'carrier_id' => 1,
                        'ml_date' => '2014-05-04'
                    ),
                    array(
                        'carrier_id' => 1,
                        'ml_date' => '2014-05-05'
                    ),
                    array(
                        'carrier_id' => 1,
                        'ml_date' => '2014-05-06'
                    ),
                );
                
                $KpiDataDay = ClassRegistry::init('Sky.KpiDataDay');
                $KpiDataDay->create();
                if ( !$KpiDataDay->saveMany($dataDay) ){
                    throw new Exception("Error al guardar DataDays");
                }
                
                
                $dailyValues = array(
                    array(
                        'kpi_data_day_id' => 1,
                        'kpi_id' => 1,
                        'value' => 67,
                    ),
                    array(
                        'kpi_data_day_id' => 1,
                        'kpi_id' => 2,
                        'value' => 37,
                    ),
                    array(
                        'kpi_data_day_id' => 1,
                        'kpi_id' => 3,
                        'value' => 375,
                    ),
                    array(
                        'kpi_data_day_id' => 1,
                        'kpi_id' => 4,
                        'value' => 375,
                    ),
                    array(
                        'kpi_data_day_id' => 1,
                        'kpi_id' => 5,
                        'value' => 375,
                    ),
                    array(
                        'kpi_data_day_id' => 2,
                        'kpi_id' => 1,
                        'value' => 31,
                    ),
                    array(
                        'kpi_data_day_id' => 3,
                        'kpi_id' => 1,
                        'value' => 45,
                    ),
                    array(
                        'kpi_data_day_id' => 2,
                        'kpi_id' => 2,
                        'value' => 3,
                    ),
                    array(
                        'kpi_data_day_id' => 2,
                        'kpi_id' => 2,
                        'value' => 4,
                    ),
                    array(
                        'kpi_data_day_id' => 4,
                        'kpi_id' => 2,
                        'value' => 6,
                    ),
                );
                
                $KpiDailyValue = ClassRegistry::init('Sky.KpiDailyValue');
                $KpiDailyValue->create();
                if ( !$KpiDailyValue->saveMany($dailyValues) ) {
                    throw new Exception("Error al guardar DailyValues");
                }
                
            } elseif ($direction === 'down') {
                // do more work here
            }
            return true;
        }


}