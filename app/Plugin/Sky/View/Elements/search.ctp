<?php
echo $this->Form->create('LogMstation', array(
    'type' => 'get',
    'class' => 'form',
    ));
?>
<div class="well">
    <div class="span2">
        <?php
        echo $this->Form->input('datetime', array( 
            'label' => 'Fecha y Hora Exacta',
            'empty' => 'Seleccione',
            ));
        
        
        echo $this->Form->input('datetime_from', array(
          //  'class' => 'icon icon-calendar',
            'label' => 'Desde',
            'after' => '<span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>',
            'div' => array(
                'id' => 'datetimepicker1',
                'class' => 'input-append date',
            )
            ));
        echo "<div class=''clearfix></div>";
        
        echo $this->Form->input('datetime_to', array( 
            'label' => 'Hasta',
            'after' => '<span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>',
            'div' => array(
                'id' => 'datetimepicker2',
                'class' => 'input-append date',
            )
            ));
        ?>
    </div>
    <div class="span2">
        <?php
        if (!empty($sites)) {
            echo $this->Form->input('site_id', array('label' => 'Sitio', 'multiple' => true));
        }
        echo $this->Form->hidden('page', array('value'=>1));
        ?>
            <div class="span2">
                <?php echo $this->Form->input('sector_name', array('label' => 'Sector')); ?>
            </div>
            <div class="span2 offset4">
                <?php echo $this->Form->input('carrier_name', array('label' => 'Carrier   ')); ?>
            </div>
    </div>
    <div class="span2">
        <?php
        echo $this->Form->input('mstation_id', array(
            'label' => 'MSI <span class="muted small">(Separar por comas para buscar varios al mismo tiempo)</span>', 
            'type'=>'text', 
            'required'=>false));
        if (!empty($mimos)) {
            echo $this->Form->input('mimo_id', array('label' => 'Mimo', 'multiple' => true));
        }
        ?>
    </div>
    <div class="span2">
        <?php
        if ( !empty($fecs) ) {
            echo $this->Form->input('dl_fec_id', array( 'multiple' => true, 'options'=> $fecs, 'label' => 'DL FEC'));
            echo $this->Form->input('ul_fec_id', array( 'multiple' => true, 'options'=> $fecs, 'label' => 'UL FEC'));
        }
        ?>
    </div>
    <div class="span2 offset1">
        <br><br><br>
        <?php
        echo $this->Form->button('Buscar', array('type'=>'submit', 'class'=>'btn btn-large btn-primary'));
        ?>
    </div>
    <div class="clearfix"></div>
</div>    
<?php
echo $this->Form->end();
?>

<div class="clearfix"></div>