<?php
$Node = ClassRegistry::init('Nodes.Node');
$conditions = array(
    'conditions' => array(
        'Node.status' => 1,
        'Node.promote' => 1,
    )
);

$conditions['conditions']['Node.type'] = 'events';
if (!empty($block['Params']['type'])) {
    $conditions['conditions']['Node.type'] = $block['Params']['type'];
}

$nodes = $Node->find('all', $conditions);
App::uses('CakeTime', 'Utility');
?>

<div class="pre-scrollable" style="height:163px;">
    
<?php
foreach ($nodes as $n) {
    $this->Nodes->set($n);
    ?>
    <div class="event-box">
        <div class="imgdiv"><?php echo $this->Nodes->body() ?></div>
        <div class="txt">
            <p class="title">
                <?php echo $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')); ?>
                <br />
                <span><?php echo CakeTime::nice($this->Nodes->field('created')); ?></span>
            </p>
            <p class="geltxt"><?php echo $this->Nodes->field('excerpt') ?></p>
        </div>                            
    </div>
    <?phP
}
?>

</div>