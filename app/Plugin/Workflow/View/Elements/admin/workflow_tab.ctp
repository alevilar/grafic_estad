<?php
if ( empty($states) ) {
	?>
	<br>
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> You have not possibles states to select
	</div>
	<?php
} else {
	echo $this->Form->input('state_id');
}
?>
