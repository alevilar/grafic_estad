
<div id="jcarousel-title-controls">
	<div class="span1 text-center">
		<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
	</div>

	<div class="jcarousel-wrapper span10">

		<div class="jcarousel">
			<ul>
				<?php foreach ($sites as $sid=>$s) { ?>
					<li><?= $this->Html->link($s, "#sitio-$sid") ?></li>
				<?php } ?>
			</ul>
		</div>

	</div>

	<div class="span1 center">
		<a href="#" class="jcarousel-control-next">&rsaquo;</a>
	</div>
</div>

<div class="clearfix"></div>


<div id="jcarousel-data">
	<div>
		<div class="span6">
			<h2>Gráfico</h2>
		</div>

		<div class="span6">
			<h2>KPI´s</h2>
		</div>			
	</div>
</div>


<?= $this->element('scroll_interval_to_js'); ?>



<?php 

echo $this->Html->script(array(
	'/skpi/js/jquery.jcarousel.min',
	'/skpi/js/data_day_monitor',
	'/skpi/flot/jquery.flot',
	'/skpi/flot/jquery.flot.time',
	'/skpi/flot/jquery.flot.selection',
	));

echo $this->Html->css('/skpi/css/jcarousel');
?>

