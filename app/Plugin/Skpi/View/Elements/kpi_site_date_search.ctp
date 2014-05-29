<?php
$this->start('script');
    echo $this->Html->script('/bootstrap_datepicker/js/bootstrap-datepicker');
    echo $this->Html->css('/bootstrap_datepicker/css/datepicker');
    ?>
    <style type="text/css">

    </style>
    <?php
$this->end();


$options = array(
    'type' => 'get',
    'class' => 'form',
    );

if ( empty($modelName) ) {
    $modelName = 'DataDay';
}

//$options['action'] = '/by_site';
if ( !empty($formAction) ) {
    $options['action'] = $formAction;
}

echo $this->Form->create( $modelName , $options);
?>




    <div class="span4">
        <?php        
        echo $this->Form->input('date_from', array(          
            'label' => 'Desde',
            'id' => 'datetimepicker1', 
            'data-date-format' => 'yyyy-mm-dd',
            'placeholder' => 'Seleccionar fecha "desde"',
            ));              
        ?>
    </div>
    <div class="span4 offset1">
    	<?php
    	 echo $this->Form->input('date_to', array( 
            'label' => 'Hasta',
          	'id' => 'datetimepicker2',
          	'data-date-format' => 'yyyy-mm-dd',
          	'placeholder' => 'Seleccionar fecha "hasta"'
            ));
    	?>
    </div>
    <div class="span2 offset1">
    	<br>     
        <?php
        echo $this->Form->button('Buscar', array(
            'type'=>'submit', 
            'class'=>'btn btn-primary'));
        ?>
        
        <?php //echo $this->Form->input('sector_name', array('label' => 'Sector')); ?>
    </div>    

<?php
echo $this->Form->end();
?>

<div class="clearfix"></div>




<script type="text/javascript">


    $('#datetimepicker2').datepicker().on('changeDate', function(ev) {  		
      		$(ev.target).datepicker('hide');
    	});


    $('#datetimepicker1').datepicker()
    	.on('changeDate', function(ev) {  		
      		$(ev.target).datepicker('hide');
    	});
</script>