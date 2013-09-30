<?php
$Node = ClassRegistry::init('Nodes.Node');
$conditions = array(
    'conditions' => array(
        'Node.status' => 1,
        'Node.promote' => 1,
        'OR' => array(
            'Node.visibility_roles' => '',
            'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
        ),
    )
);

if (!empty($block['Params']['type'])) {
    $conditions['conditions']['Node.type'] = $block['Params']['type'];
}

$nodes = $Node->find('all', $conditions);
?>

<?php
foreach ($nodes as $n) {
    $this->Nodes->set($n);
    ?>
    <div class="blog-box">
        <div class="txt">
            <p class="title">
    <?php echo $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')); ?>
            </p>
            <p class="geltxt"><?php echo $this->Nodes->field('excerpt') ?></p>
        </div>                            
    </div>
    <?phP
}
?>
<div class="clear"></div>
