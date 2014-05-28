<?php
    echo $this->Html->script('/bootstrap_datepicker/js/bootstrap-datepicker');
    echo $this->Html->css('/bootstrap_datepicker/css/datepicker');



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

<style>
    .search-form select{
        width: 100%;
    }
    
    .search-form input{
        width: 100%;
    }
    
    .search-form .date input{
        width: auto;
    }
    
    .bootstrap-datetimepicker-widget{
        top: 400px;
    }
</style>


<div class="search-form">
    <div class="span4">
        <?php        
        echo $this->Form->input('date_from', array(          
            'label' => array(
                    'text' => 'Desde',
                    'class' => 'control-label'
                ),
            'id' => 'datetimepicker1', 
            'data-date-format' => 'yyyy-mm-dd',
            'placeholder' => 'Seleccionar fecha "desde"',
            'class' => 'controls',
            'div' => array(
                'class' => 'control-group'
                )
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