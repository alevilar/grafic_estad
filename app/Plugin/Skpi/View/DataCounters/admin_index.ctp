<?php

$this->extend('/Common/admin_index');
$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Métricas'), $this->here);
?>

<style type="text/css">
	.nav-buttons{
		display: none;
	}
</style>

<div class="pull-right">
<?php echo $this->element('Skpi.btn_descargar_excel'); ?>
</div>

<h1>Contadores</h1>


<?php echo $this->Form->create('DataCounter', array('type'=>'get')); ?>
<div class="">
	<div class="span3">
		<?php echo $this->Form->input('objectno', array('empty' => 'Seleccione',)); ?>
	</div>

	<div class="span3">
		<?php
		echo $this->Form->input('date_time_desde', array(
			'label'=>'Fecha desde', 
			'class'=>'datetime', 
			'value'=>$datetime_desde,			
			'placeholder' => 'formato: YYYY-MM-DD HH:MM:SS',
			));
		?>
	</div>

	<div class="span3">
		<?php
		echo $this->Form->input('date_time_desde', array(
			'label'=>'Fecha desde', 
			'class'=>'datetime', 
			'value'=>$datetime_desde,
			'placeholder' => 'formato: YYYY-MM-DD HH:MM:SS',
			));
		?>
	</div>

	<div class="span3">
		<br>

		<?php echo $this->Form->submit('Buscar', array('class'=>'btn btn-primary')); ?>
	</div>
</div>



<?php echo $this->Form->end(); ?>

<?php echo $this->element('Skpi.data_counters_table')?>