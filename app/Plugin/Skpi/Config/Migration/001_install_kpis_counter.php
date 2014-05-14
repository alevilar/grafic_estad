<?php
class Install52KpiCounter extends CakeMigration {

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
			//	'sky_date_kpis',                                
			),
			'create_table' => array(
                                                          
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
					'col_name' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => null, 'unique'=>1),
                                        'name' => array('type' => 'string', 'length' => 64, 'null' => false, 'default' => null),                                        
                                        'string_format' => array('type' => 'string', 'length' => 64,'null' => false, 'default' => ''),
                                        'sql_formula' => array('type' => 'text', 'null' => true, 'default' => null),
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
            $Kpi = ClassRegistry::init('Sky.Kpi');
            if ($direction === 'up') {
                $kpiFields['Kpi'] = array(	                    
                    array(
                        'col_name'    => 'max_dl',
                        'name'  => 'Máximo tráfico DL',
                        'string_format' => '%sKbit/s',
                    ),
                    array(
                        'col_name'    => 'max_ul',
                        'name'  => 'Máximo tráfico UL',
                        'string_format' => '%sKbit/s',
                    ),
                    
                    
                    
                    array(
                        'col_name'    => 'init_net_entr_succ_rate',
                        'name'  => 'Initial Network Entry Success Rate',
                        'string_format' => '%.4G%%',
                        'sql_threshold_warning' => '? >= 70 && ? < 80',
                        'sql_threshold_danger' => '? < 70',
                        'sql_formula' => 'AVG(init_net_entr_succ_rate)'
                    ),
                    array(
                        'col_name'    => 'succ_rate_of_net_re_entry_in_idle_mode',
                        'name'  => 'Success Rate of Network Re-Entry in Idle Mode',
                        'string_format' => '%.4G%%',
                        'sql_threshold_warning' => '? >= 85 && ? < 95',
                        'sql_threshold_danger' => '? < 85',
                        'sql_formula' => 'AVG(succ_rate_of_net_re_entry_in_idle_mode)'
                    ),
                    
                    /**
                     * Radio Drop Rate = 
                     * (Times of Deregistration due to Air Link Failure 
                     * + Times of Deregistration due to Handover Failure) 
                     * / 
                     * (Number of Users at End of Measurement Period 
                     * + Times of MS Disconnection from Network 
                     * + Times of Deregistration Initiated by MS 
                     * + Times of Deregistration Initiated by GW 
                     * + Times of Deregistration due to OM 
                     * + Times of Deregistration on Source BS Side After Successful Handover 
                     * + Times of Deregistration due to MS Power-Off)
                     */
                    array(
                        'col_name'    => 'radio_dropt_rate',
                        'name'  => 'Radio Drop Rate',
                        'string_format' => '%.4G%%',
                        'sql_threshold_warning' => '? > 2 && ? <= 5',
                        'sql_threshold_danger' => '? > 5',
                        'sql_formula' => '
                            (
                              SUM(times_of_dereg_due_to_air_lnk_failure) 
                            + SUM(times_of_dereg_due_to_hdover_failure) 
                            ) / (
                              SUM(nr_of_users_at_end_of_measur_period)
                            + SUM(times_of_ms_diconn_from_net)
                            + SUM(times_of_dereg_init_by_ms)
                            + SUM(times_of_dereg_init_by_gw)
                            + SUM(times_of_dereg_due_to_om)
                            + SUM(times_of_dereg_on_src_bs_side_aft_succ_hdover)
                            + SUM(times_of_dereg_due_to_ms_pwroff)
                            )',
                    ),
                    
                    /**
                     * Network Disconnection Ratio = 
                     * 
                     * Times of MS Disconnection from Network / 
                     * 
                     * (Number of Users at End of Measurement Period 
                     * + Times of MS Disconnection from Network 
                     * + Times of Deregistration Initiated by MS 
                     * + Times of Deregistration Initiated by GW 
                     * + Times of Deregistration due to OM 
                     * + Times of Deregistration on Source BS Side After Successful Handover 
                     * + Times of Deregistration due to MS Power-Off)
                     */
                    array(
                        'col_name'    => 'net_discon_ratio',
                        'name'  => 'Network Disconnection Ratio',
                        'string_format' => '%.4G%%',
                        'sql_threshold_warning' => '? > 3 && ? <= 6',
                        'sql_threshold_danger' => '? > 6',
                        'sql_formula' => '
                            (
                              SUM(nr_of_users_at_end_of_msrmt_period) 
                            ) / (
                              SUM(nr_of_users_at_end_of_measur_period)
                            + SUM(times_of_ms_diconn_from_net)
                            + SUM(times_of_dereg_init_by_ms)
                            + SUM(times_of_dereg_init_by_gw)
                            + SUM(times_of_dereg_due_to_om)
                            + SUM(times_of_dereg_on_src_bs_side_aft_succ_hdover)
                            + SUM(times_of_dereg_due_to_ms_pwroff)
                            )',
                    ),
                    array(                        
                        'col_name'    => 'carrier_dl_be_avg_traffic_rate',
                        'name'  => 'Carrier DL BE Average Traffic Rate (All Day)',
                        'string_format' => '%s Mbps',
                        'sql_formula' => 'AVG(carrier_dl_be_avg_traffic_rate)'
                    ),
                    array(
                        'col_name'    => 'avg_net_entry_dly_of_usrs_on_carrier',
                        'name'  => 'Average Network Entry Delay of Users',
                        'string_format' => '%s ms',
                        'sql_threshold_warning' => '? > 3000 && ? <= 10000',
                        'sql_threshold_danger' => '? > 10000',
                        'sql_formula' => 'AVG(avg_net_entry_dly_of_usrs_on_carrier)'
                    ),
                    
                    /**
                     * UL PER = 
                     * Number of UL HARQ Subbursts Failing to Be Received Finally 
                     * / (
                     * UL HARQ Subburst Number of Receiving Success in One Time
                     * + 1st Retransmission UL HARQ Subburst of Receiving Success 
                     * + 2nd Retransmission UL HARQ Subburst of Receiving Success 
                     * + 3rd Retransmission UL HARQ Subburst of Receiving Success 
                     * + 4th Retransmission UL HARQ Subburst of Receiving Success 
                     * + UL HARQ Subburst Number of Receiving Failture
                     * ) * 100%
                     */
                    array(
                        'col_name'    => 'ul_per',
                        'name'  => 'UL PER',
                        'sql_threshold_warning' => '? > 1 && ? <= 3',
                        'sql_threshold_danger' => '? > 3',
                        'sql_formula' => '
                            (
                              SUM(nr_of_ul_harq_subbrts_fail_to_be_rec_fin) 
                            ) / (
                              SUM(nr_of_ul_harq_subbrts_succ_rcvd_once)
                            + SUM(nr_of_ul_harq_subbrts_succ_retr_at_1st_time)
                            + SUM(nr_of_ul_harq_subbrts_succ_retr_at_2nd_time)
                            + SUM(nr_of_ul_harq_subbrts_succ_retr_at_3rd_time)
                            + SUM(nr_of_ul_harq_subbrts_succ_retr_at_4th_time)                            
                            ) 
                            * 100',
                    ),
                    
                    /**
                     * 
                     * DL PER = 
                     * DL HARQ Subburst Number of Sending Failture 
                     * / (
                     * DL HARQ Subburst Number of Receiving Success in One Time 
                     * + 1st Retransmission DL HARQ Subburst of Receiving Succe 
                     * + 2nd Retransmission DL HARQ Subburst of Receiving Success 
                     * + 3rd Retransmission DL HARQ Subburst of Receiving Success 
                     * + 4th Retransmission DL HARQ Subburst of Receiving Success 
                     * + DL HARQ Subburst Number of Receiving Failture) * 100%
                     */
                    array(
                        'col_name'    => 'dl_per',
                        'name'  => 'DL PER',
                        'sql_threshold_warning' => '? > 1 && ? <= 2',
                        'sql_threshold_danger' => '? > 2',
                        'string_format' => '%.4G%%',
                        'sql_formula' => '
                            (
                              SUM(dl_harq_subbrts_nr_of_sndng_failure_mimo_b) 
                            ) / (
                              SUM(dl_harq_subbrts_nr_of_sndng_succ_one_time_mimo_b)
                            + SUM(1st_retr_dl_harq_subbrst_of_snd_succ_mimo_b)
                            + SUM(2nd_retr_dl_harq_subbrst_of_snd_succ_mimo_b)
                            + SUM(3rd_retr_dl_harq_subbrst_of_snd_succ_mimo_b)
                            + SUM(4th_retr_dl_harq_subbrst_of_snd_succ_mimo_b)                          
                            ) 
                            * 100',
                    ),
                    
                    array(
                        'col_name'    => 'avg_ul_slot_coding_effi',
                        'string_format' => '%s%%',
                        'name'  => 'Average UL Slot Coding Efficiency',
                        'string_format' => '%.4G%%',
                        'sql_formula' => 'AVG(avg_ul_slot_coding_effi)',
                    ),
                    
                    array(
                        'col_name'    => 'avg_dl_slot_coding_effi',
                        'name'  => 'Average DL Slot Coding Efficiency',
                        'string_format' => '%s bpsc',
                        'sql_formula' => 'AVG(avg_dl_slot_coding_effi)',
                    ),
                    
                    
                    array(
                        'col_name'    => 'nr_of_activ_users_wasn9770',
                        'name'  => 'Number of Activated Users (WASN9770)',
                        'string_format' => '%d',
                        'sql_formula' => 'MAX(nr_of_activ_users_wasn9770)',
                    ),
                    
                    /**
                     * 
                     * Access Success Rate = (
                     * Times of Successful Registration for Initial Network Entry 
                     * + Times of Successful Network Re-Entry from Idle Mode 
                     * + Times of Successful MS-Initiated Re-Authorization) 
                     * / (
                     * Number of Initial Network Entry Requests 
                     * + Times of Network Re-Entry from Idle Mode 
                     * + Times of MS-Initiated Re-Authorization 
                     * - Number of Initial Network Entry Failures due to Rejection from Network Side 
                     * - Number of Network Entry Failures due to Inter-Frequency Assignment Caused by No Access Permission
                     * ) * 100%
                     * 
                     */
                    array(
                        'col_name'    => 'access_success_rate',
                        'name'  => 'Access Success Rate',
                        'sql_threshold_warning' => '? >= 80 && ? <= 90',
                        'sql_threshold_danger' => '? < 80',
                        'string_format' => '%.4G%%',
                        'sql_formula' => '
                            (
                                SUM(times_of_succ_regis_for_init_net_entry) 
                              + SUM(times_of_succ_net_re_entry_from_idle_mode) 
                              + SUM(times_of_succ_ms_init_re_auth) 
                            ) / (
                              SUM(nr_of_init_net_entry_req)
                            + SUM(times_of_net_re_entry_from_idle_mode)
                            - SUM(nr_of_init_net_entry_fails_due_to_rej_from_net_side)
                            - SUM(nr_of_net_entry_fails_due_to_inter_freq_assig_cd_by_no_acc_perm)
                            ) 
                            * 100',
                    ),
                    
                    /**
                     * Radio Access Success Rate = 
                     * (Number of Basic Capability Negotiation Requests 
                     * + Times of Successful Network Re-Entry from Idle Mode) 
                     * / ( 
                     * Number of Initial Network Entry Requests 
                     * + Times of Network Re-Entry from Idle Mode 
                     * - Number of Network Entry Failures due to Inter-Frequency Assignment Caused by No Access Permission
                     * ) * 100% 
                     */
                    array(
                        'col_name'    => 'radio_access_rate',
                        'name'  => 'Radio Access Rate',
                        'sql_threshold_warning' => '? >= 90 && ? <= 97',
                        'sql_threshold_danger' => '? < 90',
                        'string_format' => '%.4G%%',
                        'sql_formula' => '
                            (
                                SUM(nr_of_basic_capability_negot_req) 
                              + SUM(times_of_succ_net_re_entry_from_idle_mode) 
                            ) / (
                              SUM(nr_of_init_net_entry_req)
                            + SUM(times_of_net_re_entry_from_idle_mode)
                            - SUM(nr_of_net_entry_fails_due_to_inter_freq_assig_cd_by_no_acc_perm)
                            ) 
                            * 100',
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
                
                                
                
            } elseif ($direction === 'down') {
                // do more work here
            }
            return true;
        }


}