<?php
    echo $this->Html->script('/bootstrap_datepicker/js/bootstrap-datepicker');
    echo $this->Html->css('/bootstrap_datepicker/css/datepicker');
 ?>

<?php

$options = array(
    'type' => 'get',
    'class' => 'form',
    );

//$options['action'] = '/by_site';
if ( !empty($formAction) ) {
    $options['action'] = $formAction;
}

echo $this->Form->create('KpiDataDay', $options);
?>

<style>
    select{
        width: 100%;
    }
    
    input{
        width: 100%;
    }
    
    .date input{
        width: auto;
    }
    
    .bootstrap-datetimepicker-widget{
        top: 400px;
    }
</style>


<div class="well">
    <div class="span2">
        <?php        
        echo $this->Form->input('date_from', array(          
            'label' => 'Desde',
            'id' => 'datetimepicker1', 
            'data-date-format' => 'yyyy-mm-dd',
            'placeholder' => 'Seleccionar fecha "desde"',            
            ));              
        ?>
    </div>
    <div class="span2">
    	<?php
    	 echo $this->Form->input('date_to', array( 
            'label' => 'Hasta',
          	'id' => 'datetimepicker2',
          	'data-date-format' => 'yyyy-mm-dd',
          	'placeholder' => 'Seleccionar fecha "hasta"'
            ));
    	?>
    </div>
    <div class="span1">
    	<br>     
        <?php
        echo $this->Form->button('Buscar', array('type'=>'submit', 'class'=>'btn btn-primary btn-block'));
        ?>
        
        <?php //echo $this->Form->input('sector_name', array('label' => 'Sector')); ?>
    </div>
    <div class="span1">
        <?php //echo $this->Form->input('carrier_name', array('label' => 'Carrier   ')); ?>
    </div>
    <div class="span2 offset1">   
    	
    </div>
    <div class="clearfix"></div>
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