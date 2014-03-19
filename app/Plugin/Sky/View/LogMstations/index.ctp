
<?php 
$urlLinda = '';

foreach ($this->params->query as $k=>$d) {
    if ( is_array($d) ){
        foreach ($d as $v) {
            $urlLinda .= $k."[]=$v&";  
        }
    } else {
        $urlLinda .= "$k=$d&";  
    }
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

echo $this->element('mstations_list');

echo $this->element('paginator_footer');
?>

