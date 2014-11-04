<?php echo $this->element('search'); ?>



<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha de la muestra</th>
            <th>MAC</th>
            <th>Repeticiones</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <?php foreach ($logMstations as $ms) { ?>
    <tr>
        <?php 
        $date = $ms['MsLogTable']['datetime'];
        echo "<td>$date</td>";
        $mac = $ms['LogMstation']['mstation_id'];
        echo "<td>$mac</td>";
        $cant = $ms[0]['COUNT( LogMstation.mstation_id )'];
        echo "<td>$cant</td>";

        $link = $this->Html->link('Ver detalle', array('action' => "index?datetime=$date&mstation_id=$mac"));
        echo "<td>$link</td>";
        ?>
    </tr>
    <?php } ?>
</table>