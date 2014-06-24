<?= $this->Html->css('/skpi/css/jcarousel'); ?>

<div>
	<div id="jcarousel-title-controls" class="span12">
		<div class="row-fluid">
			<div class="span1 text-center">
				<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
			</div>

			<div class="jcarousel-wrapper span10">

				<div class="jcarousel">
					<ul>
						<?php foreach ($sites as $sid=>$s) { ?>
						<li><?= $this->Html->link($s, array(
								'controller' => 'data_days',
								'action' => 'view',
								'site',
								$sid,
								),
								array(
									'fullBase' => true,
									'data-site-id' => $sid
									)
							) ?>
						</li>
						<?php } ?>
					</ul>
				</div>

			</div>

			<div class="span1 center">
				<a href="#" class="jcarousel-control-next">&rsaquo;</a>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>


<div>
	<div id="jcarousel-data" class="span12" style="min-height: 700px;">
		<?php foreach ($sites as $sid=>$s) { ?>
			<? $divId = "container-info-site-". $sid; ?>
			<div id="<?= $divId?>" display: none></div>
		<?php } ?>
	</div>
</div>



<?= $this->element('scroll_interval_to_js'); ?>



<?php 


echo $this->Html->script(array(
		'/skpi/js/jquery.jcarousel.min',
		'/skpi/js/data_day_monitor',

        '/jqplot/jquery.jqplot',
        '/jqplot/plugins/jqplot.dateAxisRenderer.min',
        '/jqplot/plugins/jqplot.pointLabels.min',
        //'/jqplot/plugins/jqplot.highlighter.min',
        '/jqplot/plugins/jqplot.cursor.min',


        '/skpi/flot/jquery.flot',
        '/skpi/flot/jquery.flot.time',
        '/skpi/flot/jquery.flot.selection',
        '/skpi/js/graphs/kpi_graph',


    ));


    echo $this->Html->css('/jqplot/jquery.jqplot.min');
    echo $this->Html->css('/skpi/css/graphs');


    ?>

    <!--[if lt IE 9]>
    <?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
    <![endif]-->
