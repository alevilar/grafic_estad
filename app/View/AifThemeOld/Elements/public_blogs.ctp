<?php
$Node = ClassRegistry::init('Nodes.Node');
$nodes = $Node->find('all', array(
   'conditions' => array(
       'Node.status' => 1,
       'Node.promote' => 1,
   )
));
?>
<div class="home-blog-container">
    <h2 class="green">Blog</h2>
    <?php
    foreach ($nodes as $n) {
        $this->Nodes->set($n);
        ?>
        <div class="blog-box">
            <div class="txt">
                <p class="title">
<?php echo $this->Nodes->field('title')?>
                </p>
                <p><?php echo $this->Nodes->field('excerpt')?></p>
                    <?php echo $this->Html->link('More...', $this->Nodes->field('url')); ?>
                <p><?php //echo $this->Nodes->field('body')?></p>
            </div>                            
        </div>
        <?phP
    }
    ?>   
    <div class="clear"></div>
</div><!-- end of home-event-container -->
