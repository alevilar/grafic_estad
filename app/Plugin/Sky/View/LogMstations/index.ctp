<?php
    echo $this->Html->script('/bootstrap_datetimepicker/js/bootstrap-datetimepicker.min');
    echo $this->Html->css('/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min');
    echo $this->Html->css('/jqplot/css/jquery.jqplot.min');
?>

<!--[if lt IE 9]>
<?php echo $this->Html->script('/jqplot/excanvas.min'); ?>
<![endif]-->

<?php echo $this->Html->script(array(
    '/jqplot/jquery.jqplot.min'
)); ?>


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

<?php 
$urlLinda = '';
foreach ($this->params->query as $k=>$d) {
    $urlLinda .= "$k=$d&";  
}
$urlLinda = trim($urlLinda, '&');

$maxReg = Configure::read('Sky.max_reg_export');
if ($maxReg) {
    $btnLinkText = "  Descargar Planilla Excel ($maxReg registros máximo)";
} else {
    $btnLinkText = "  Descargar Planilla Excel";
}


echo $this->Html->link( $btnLinkText,
        Router::url($this->action, true) . '.xls?'.$urlLinda, 
        array('class'=> 'pull-right btn btn-success btn-large icon icon-download')); ?>
<h1>Tabla Histórica</h1>

<?php echo $this->element('search'); ?>


    <?php
echo $this->Paginator->counter(
        'Page {:page} of {:pages}, showing {:current} records out of
     {:count} total, starting on record {:start}, ending on {:end}'
);
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('MsLogTable.datetime', 'Fecha')?></th>
            <th><?php echo $this->Paginator->sort('MsLogTable.sitio_id', 'Sitio')?></th>
            <th><?php echo $this->Paginator->sort('Sector.name', 'Sector')?></th>
            <th><?php echo $this->Paginator->sort('Carrier.name', 'Carrier')?></th>
            <th><?php echo $this->Paginator->sort('LogMstation.mstation_id', 'Msi')?></th>
            <th><?php echo $this->Paginator->sort('LogMstation.mimo_id', 'Mimo')?></th>
            <th><?php echo $this->Paginator->sort('LogMstation.dl_fec_id', 'Dl Fec')?></th>
            <th>Dl Modul.</th>
            <th><?php echo $this->Paginator->sort('LogMstation.ul_fec_id', 'Ul Fec')?></th>
            <th>Ul Modul.</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($log_mstations as $ms) : ?>
        <tr>
            <td><?php echo $ms['MsLogTable']['datetime']?></td>
            <td><?php echo $ms['Site']['name']?></td>
            <td><?php echo $ms['Sector']['name']?></td>
            <td><?php echo $ms['Carrier']['name']?></td>
            <td><?php echo $ms['LogMstation']['mstation_id']?></td>
            <td><?php echo $ms['LogMstation']['mimo_id']?></td>
            <td><?php echo $ms['DlFec']['id']?></td>
            <td><?php echo $ms['DlFec']['modulation']?></td>
            <td><?php echo $ms['UlFec']['id']?></td>
            <td><?php echo $ms['UlFec']['modulation']?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php

//debug($log_mstations);
?>
</table>




<div class="pagination" style="text-align: center">	
        <div class="btn-group">
            <?php
//            echo $this->Paginator->prev('< ' . __d('croogo', 'prev'));
//            echo $this->Paginator->numbers();
//            echo $this->Paginator->first('< ' . __d('croogo', 'first'));
//            echo $this->Paginator->prev('< ' . __d('croogo', 'prev'));


            echo $this->Paginator->prev('« Previous', array('class' => 'btn'), null, array('class' => 'btn disabled', 'escape' => 'true'));

            // Shows the page numbers
            echo $this->Paginator->numbers(array(
                'first' => 3,
                'last' => 3,
                'separator' => '', 
                'class' => 'btn'));

            echo $this->Paginator->next('Next »', array('class' => 'btn'), null, array('class' => 'btn'));
            ?>
        </div>
        <div>
            <?php
            // prints X of Y, where X is current page and Y is number of pages
            echo $this->Paginator->counter();
            ?>
        </div>
    </div>


<script type="text/javascript">
    $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'pt-BR'
    });
    
    $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'pt-BR'
    });
</script>