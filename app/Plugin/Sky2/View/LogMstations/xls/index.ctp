
<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Sitio</th>
            <th>Sector</th>
            <th>Carrier</th>
            
            <th>Msi</th>
            
            <th>MSSTATUS</th>
            
            <th>MSPWR(dBm)</th>
            <th>DLCINR(dB)</th>
            <th>ULCINR(dB)</th>
            <th>DLRSSI(dBm)</th>  
            <th>ULRSSI(dBm)</th>
            <th>DLFEC</th>
            <th>DLFEC MODULACION</th>
            <th>ULFEC</th>
            <th>ULFEC MODULACION</th>
            <th>DLREPETITIONFATCTOR</th>
            <th>ULREPETITIONFATCTOR</th>
            <th>DLMIMOFLAG</th>
            <th>BENUM</th>
            <th>NRTPSNUM</th>
            <th>RTPSNUM</th>
            <th>ERTPSNUM</th>
            <th>UGSNUM</th>
            <th>UL PER for an MS(0.001)</th>
            <th>NI Value of the Band Where an MS Is Located(dBm)</th>
            <th>DL Traffic Rate for an MS(byte/s)</th>
            <th>UL Traffic Rate for an MS(byte/s)</th>
            
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
            <td><?php echo $ms['LogMstation']['status_id']?></td>
            <td><?php echo $ms['LogMstation']['mstation_pwr']?></td>            
            <td><?php echo $ms['LogMstation']['dl_cinr']?></td>
            <td><?php echo $ms['LogMstation']['ul_cinr']?></td>
            <td><?php echo $ms['LogMstation']['dl_rssi']?></td>
            <td><?php echo $ms['LogMstation']['ul_rssi']?></td>
            <td><?php echo $ms['DlFec']['id']?></td>
            <td><?php echo $ms['DlFec']['modulation']?></td>
            <td><?php echo $ms['UlFec']['id']?></td>
            <td><?php echo $ms['UlFec']['modulation']?></td>
            <td><?php echo $ms['LogMstation']['dl_repetitionfatctor']?></td>
            <td><?php echo $ms['LogMstation']['ul_repetitionfatctor']?></td>
            <td><?php echo $ms['LogMstation']['mimo_id']?></td>
            <td><?php echo $ms['LogMstation']['benum']?></td>
            <td><?php echo $ms['LogMstation']['nrtpsnum']?></td>
            <td><?php echo $ms['LogMstation']['rtpsnum']?></td>
            <td><?php echo $ms['LogMstation']['ertpsnum']?></td>
            <td><?php echo $ms['LogMstation']['ugsnum']?></td>
            <td><?php echo $ms['LogMstation']['ul_per_for_an_ms']?></td>
            <td><?php echo $ms['LogMstation']['ni_value']?></td>
            <td><?php echo $ms['LogMstation']['dl_traffic_rate']?></td>
            <td><?php echo $ms['LogMstation']['ul_traffic_rate']?></td>
            
            
            
            
            
            
            
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php

//debug($log_mstations);
?>
</table>
