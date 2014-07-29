<?php

$this->extend('/Common/admin_index');
$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('sky', 'Probe Values'), $this->here);



echo $this->Form->create('ProbeValue', array('type'=>'get'));

?>

<div class="pull-right">
<?php echo $this->element('Skpi.btn_descargar_excel'); ?>
</div>

<h1>Valores por Probe</h1>



<div class="span3">
<?php echo $this->Form->input('probe_id', array('empty'=>'Seleccione')); ?>
</div>

<div class="span3">
<?php echo $this->Form->input('date_time_from', array('placeholder'=>'Formato: YYYY-MM-DD HH:MM:SS')); ?>
</div>

<div class="span3">
<?php echo $this->Form->input('date_time_to', array('placeholder'=>'Formato: YYYY-MM-DD HH:MM:SS')); ?>
</div>

<div class="span2">
	<br>
<?php echo $this->Form->submit('Buscar', array('class'=>'btn btn-large btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>

<div class="clearfix"></div>
<div class="probeValues index">
	<?php echo $this->element('Skpi.probe_values_table'); ?>
</div>
