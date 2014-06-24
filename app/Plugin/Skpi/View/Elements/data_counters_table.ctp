
<?php
// debug($fields);
 // debug($dataCounters);
?>

<table class="table">
	<?php

	$fullfields = array_merge(array('Sitio', 'Sector', 'Carrier'), $fields);
	echo $this->Html->tableHeaders($fullfields);

	$tCells = array();
	foreach ($dataCounters as $dc ) {
		$datafields = array();

		if (!empty($dc['Carrier']['Sector']) && !empty($dc['Carrier']['Sector']['Site'])) {
			$datafields[] = $dc['Carrier']['Sector']['Site']['name'];		 			 	
		} else {
			$datafields[] = "&nbsp;";
		}

		if ( !empty($dc['Carrier']['Sector']) ) {
			$datafields[] = $dc['Carrier']['Sector']['name'];		 			 	
		} else {
			$datafields[] = "&nbsp;";
		}
		
	 	$datafields[] = $dc['Carrier']['name'];
	
		foreach ($fields as $f ) {
			// debug($f);
			if (!empty($dc['DataCounter'][$f])) {
				$datafields[] = $dc['DataCounter'][$f];
			} else {
				$datafields[] = "&nbsp;";
			}
		}

		 $tCells[] = $datafields;
	}

	echo $this->Html->tableCells( $tCells );

	?>
</table>