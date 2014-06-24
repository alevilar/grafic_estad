
	SELECT DISTINCT
	ms.id
	FROM
	sky_log_mstations ms
	LEFT JOIN sky_ms_log_tables lt on lt.id = ms.ms_log_table_id
	WHERE
	lt.ms_datetime BETWEEN '2014-06-01 00:00:00' AND '2014-06-04 00:30:00' 
	GROUP BY
	lt.ms_datetime, 
	ms.mstation_id,
	ms.mimo_id,
	status_id,
	dl_cinr,
	mstation_pwr,
	ul_cinr,
	dl_rssi,
	ul_rssi,
	dl_fec_id,
	ul_fec_id,
	dl_repetitionfatctor,
	ul_repetitionfatctor,
	mimo_id,
	benum,
	nrtpsnum,
	rtpsnum,
	ertpsnum,
	ugsnum,
	ul_per_for_an_ms,
	ni_value,
	dl_traffic_rate,
	ul_traffic_rate


	HAVING 
	COUNT( ms.mstation_id ) > 1
	ORDER BY ms.created DESC
