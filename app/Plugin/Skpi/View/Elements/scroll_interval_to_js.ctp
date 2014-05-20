<?php
	$interval = Configure::read('Sky.MsRotacionSitios');
	if (!empty($interval) || !is_numeric($interval)) {
		$interval = 10000; // set default value
	}
?>
<script>
	var scrollInterval= <?= $interval ?>;
</script>