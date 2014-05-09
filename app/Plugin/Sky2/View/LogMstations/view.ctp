<?php

//debug($logMstation);

?>

<h1>MAC <?php echo $logMstation['LogMstation']['mstation_id']?></h1>

<div class="span2">
<dl>
        <dt>Status</dt>
        <dd><?php echo $logMstation['Status']['id']?></dd>
        
        <dt>PWD</dt>
        <dd><?php echo $logMstation['LogMstation']['mstation_pwr']?></dd>
        
        <dt>DL CINR</dt>
        <dd><?php echo $logMstation['LogMstation']['dl_cinr']?></dd>
        
        <dt>UL CINR</dt>
        <dd><?php echo $logMstation['LogMstation']['ul_cinr']?></dd>
        
        <dt>DL RSSI</dt>
        <dd><?php echo $logMstation['LogMstation']['dl_rssi']?></dd>
        
        <dt>UL RSSI</dt>
        <dd><?php echo $logMstation['LogMstation']['ul_rssi']?></dd>
        
        
</dl>
    
    </div>

<div class="span2">
    <dl>
        <dt>DL FEC</dt>
        <dd><?php echo $logMstation['DlFec']['id']?></dd>

        <dt>DL MODULACION</dt>
        <dd><span style='color: <?php echo $logMstation['DlFec']['line_color']?>'> <?php echo $logMstation['DlFec']['modulation'] ?> </span></dd>
                  
        <dt>UL FEC</dt>
        <dd><?php echo $logMstation['UlFec']['id']?></dd>

        <dt>UL MODULACION</dt>
        <dd><span style='color: <?php echo $logMstation['UlFec']['line_color']?>'> <?php echo $logMstation['UlFec']['modulation'] ?> </span></dd>
        
        <dt>dl_repetitionfatctor</dt>
        <dd><?php echo $logMstation['LogMstation']['dl_repetitionfatctor']?></dd>
        
        <dt>ul_repetitionfatctor</dt>
        <dd><?php echo $logMstation['LogMstation']['ul_repetitionfatctor']?></dd>
        
        <dt>MIMO</dt>
        <dd style="color: <?php echo $logMstation['Mimo']['line_color']?>"><?php echo $logMstation['Mimo']['id']?></dd>
        
    </dl>
    
</div>



<div class="span2">

<dl>
        
        <dt>Benum</dt>
        <dd><?php echo $logMstation['LogMstation']['benum']?></dd>
        
        <dt>nrtpsnum</dt>
        <dd><?php echo $logMstation['LogMstation']['nrtpsnum']?></dd>
        
        <dt>rtpsnum</dt>
        <dd><?php echo $logMstation['LogMstation']['rtpsnum']?></dd>
        
        <dt>ertpsnum</dt>
        <dd><?php echo $logMstation['LogMstation']['ertpsnum']?></dd>
        
        <dt>ugsnum</dt>
        <dd><?php echo $logMstation['LogMstation']['ugsnum']?></dd>
        
        
        
    </dl>
</div>

<div class="span2">
    <dl>
        <dt>ul_per_for_an_ms</dt>
        <dd><?php echo $logMstation['LogMstation']['ul_per_for_an_ms']?></dd>
        
        <dt>ni_value</dt>
        <dd><?php echo $logMstation['LogMstation']['ni_value']?></dd>
        
        <dt>dl_traffic_rate</dt>
        <dd><?php echo $logMstation['LogMstation']['dl_traffic_rate']?></dd>
        
        <dt>ul_traffic_rate</dt>
        <dd><?php echo $logMstation['LogMstation']['ul_traffic_rate']?></dd>
        
        <dt>created</dt>
        <dd><?php echo $logMstation['LogMstation']['created']?></dd>
    </dl>
</div>

<div class="span2 well well-large">
    <?php
    echo $this->Form->postLink(__d('cake', 'Delete %s', 'MStation'), 
            array('action' => 'delete', $logMstation['LogMstation']['id']), null, 'Seguro desea eliminar esta MAC de la base de datos?');
    ?>
</div>
