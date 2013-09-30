<?php
$crumbs = $this->Html->getCrumbs(
		//$this->Html->tag('span', '-', array( 'class' => 'divider',))
);
?>
<?php if ($crumbs): ?>
	<div class="bredcrumb"><p>You are <span><?php echo $crumbs; ?></span></p></div>
<?php endif; ?>
