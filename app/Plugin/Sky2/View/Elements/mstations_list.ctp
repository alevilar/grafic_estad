
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
            <th></th>
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
            <td><?php echo $this->Html->link('View', array('action'=>'view', $ms['LogMstation']['id']) )?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php

//debug($log_mstations);
?>
</table>