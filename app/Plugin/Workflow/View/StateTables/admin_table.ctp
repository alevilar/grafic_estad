<?php

echo "<h3>$title_for_layout</h3>";
echo "Role: <strong>".$roleName."</strong>";
echo "<br>";
echo "Content Type: <strong>".$contentTypeName."</strong>";


echo $this->Form->create('StateTable', array('action'=>'table_process'));

echo $this->Form->hidden("role_id");
echo $this->Form->hidden("type_id");
?>

<table class="table table-striped">
<?php
	$headertable = array('');
	foreach ($states as $s) {
		$headertable[] =  $s;
	}
	$tableHeaders = $this->Html->tableHeaders($headertable);
?>
	<thead>
		<?php echo $tableHeaders; ?>
	</thead>
<?php

	$rows = array();
	$statesRow = $states;
	$i = 0;
	foreach ($states as $sToId => $state) :
		$rows[$i] = array( $state );
		foreach ( $statesRow as $sFromId=>$srName ) {
			$rows[$i][] = $this->Form->checkbox("checkedStates.$sFromId.$sToId");
		}
		$i++;
	endforeach;

	echo $this->Html->tableCells($rows);
?>
</table>

<?php

echo $this->Form->end('Save');
