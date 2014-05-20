<?php
$dateFrom = $dateTo = '';
if (!empty($this->request->data['DataDay']['date_to'])) {
    $dateTo = $this->request->data['DataDay']['date_to'];
}
if (!empty($this->request->data['DataDay']['date_from'])) {
    $dateFrom = $this->request->data['DataDay']['date_from'];
}
?>

<h2 style="float: left; margin-right: 10px;"><?php echo $title_for_layout ?></h2>

<div class="btn-toolbar pull-right text-small">
    <?php
    $classSite = '';
    if ( $this->request->params['pass'][0] == 'site' && $this->request->params['pass'][1] == $site['Site']['id'] ) {
        $classSite = 'active';
    }

    echo $this->Html->link('Sitio: '.$site['Site']['name'], array(
                'controller' => 'data_days',
                'action' => 'view', 
                'site',
                $site['Site']['id'], 
                $dateFrom, 
                $dateTo),
				array(
                    'class' => "btn btn-primary $classSite"
				)
			);
    ?>


    <?php
    foreach ($site['Sector'] as $sec) {
        ?>


        <div class="btn-group">
            <?php
            $classSec = '';
            if ( $this->request->params['pass'][0] == 'sector' && $this->request->params['pass'][1] == $sec['id'] ) {
                $classSec = 'active';
            }

            echo $this->Html->link('s ' . $sec['name'], array(
                'controller' => 'data_days',
                'action' => 'view', 
                'sector',
                $sec['id'], 
                $dateFrom, 
                $dateTo), array(
                'class' => "btn btn-primary $classSec"
                    )
            );

            foreach ($sec['Carrier'] as $car) {
                $class = '';
                if ( $this->request->params['pass'][0] == 'carrier' && $this->request->params['pass'][1] == $car['id'] ) {
                    $class = 'active';
                }

                echo $this->Html->link('c ' . $car['name'], array(
                    'controller' => 'data_days',
                    'action' => 'view', 
                    'carrier',
                    $car['id'], 
                    $dateFrom, 
                    $dateTo
                    ), array(
                        'class' => "btn $class"
                        )
                );
            }
            ?>            
        </div>

        <?php
    }
    ?>
</div>