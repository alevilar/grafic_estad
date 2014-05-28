<?php
$rand = rand();
?>
<div>
	<div id="detail_graph_<?= $rand.$counter['Counter']['id']?>" class="counter-graph counter-detail"></div>
	<div id="master_graph_<?= $rand.$counter['Counter']['id']?>" class="counter-graph counter-master"></div>
</div>


<script type="text/javascript">
	var data = <?= json_encode( $metrics, JSON_NUMERIC_CHECK); ?>;
 
    var dataDetail = [
            {
                label: "<?= $counter['Counter']['string_format'] ?>",
                data: data
            }
        ];

    var yaxisLabel = "<?= sprintf($counter['Counter']['string_format'], '')?>";
    var ops = {'yaxisLabel' : yaxisLabel}

	$( function() {
		create_zomming_plot("#master_graph_<?= $rand.$counter['Counter']['id']?>", "#detail_graph_<?= $rand.$counter['Counter']['id']?>", dataDetail, ops);	
	});
</script>
